<?php

namespace App\Controllers;

use App\Models\PropertyImageModel;
use App\Models\PropertyModel;
use App\Models\MessageModel;
use App\Models\OrderModel;
use App\Models\UserModel;


class SellerController extends BaseController
{
    protected $propertyModel;
    protected $propertyImageModel;
    protected $messageModel;
    protected $orderModel;
    protected $userModel;

    public function __construct()
    {
        $this->propertyModel = new PropertyModel();
        $this->propertyImageModel = new PropertyImageModel();
        $this->messageModel = new MessageModel();
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
    }

    public function dashboard()
    {
        $this->requireLogin();
        $this->requireRole(['seller', 'admin']);

        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $properties = $this->propertyModel->getByUser($userId);
          foreach ($properties as &$property) {
            $primaryImage = $this->propertyImageModel->getPrimaryImage($property['id']);
            $property['image'] = $primaryImage['image_path'] ?? null;
        }
        unset($property);

        $totalProperties = count($properties);
        $totalViews = array_sum(array_column($properties, 'views'));
        $totalMessages = $this->messageModel->where('receiver_id', $userId)->countAllResults();

        $totalActive = 0;
        foreach ($properties as $property) {
            $isActive = !empty($property['is_active']) && (int) $property['is_active'] === 1 && !in_array(($property['status'] ?? ''), ['dipesan', 'terjual'], true);
            if ($isActive) {
                $totalActive++;
            }
        }

        $totalSold = $this->orderModel
            ->where('seller_id', (int) $userId)
            ->where('payment_type', 'pelunasan')
            ->where('status', 'paid')
            ->countAllResults();

        $revenueRow = $this->orderModel
            ->selectSum('amount', 'total')
            ->where('seller_id', (int) $userId)
            ->where('status', 'paid')
            ->first();

        $totalRevenue = (float) ($revenueRow['total'] ?? 0);
        $statusCounts = [
            'dijual' => 0,
            'disewa' => 0,
            'nonaktif' => 0,
        ];

        $monthlyStats = [];
        $monthCursor = new \DateTime('-5 months');
        for ($i = 0; $i < 6; $i++) {
            $key = $monthCursor->format('Y-m');
            $monthlyStats[$key] = [
                'label' => $monthCursor->format('M Y'),
                'active' => 0,
                'sold' => 0,
                'revenue' => 0,
            ];
            $monthCursor->modify('+1 month');
        }

        foreach ($properties as $property) {
            $isActive = !empty($property['is_active']) && (int) $property['is_active'] === 1 && ($property['status'] ?? '') !== 'dipesan';

            if ($isActive) {
                if (($property['status'] ?? '') === 'disewa') {
                    $statusCounts['disewa']++;
                } else {
                    $statusCounts['dijual']++;
                }
            } else {
                $statusCounts['nonaktif']++;
            }
        }

        $orders = $this->orderModel
            ->where('seller_id', (int) $userId)
            ->where('status', 'paid')
            ->findAll();

        foreach ($orders as $order) {
            $monthKey = date('Y-m', strtotime($order['created_at'] ?? 'now'));
            if (!isset($monthlyStats[$monthKey])) {
                continue;
            }
            if (($order['payment_type'] ?? '') === 'pelunasan') {
                $monthlyStats[$monthKey]['sold']++;
            }
            $monthlyStats[$monthKey]['revenue'] += (float) ($order['amount'] ?? 0);
        }

        $recentOrders = $this->orderModel
            ->select('orders.*, properties.title as property_title, buyer.name as buyer_name')
            ->join('properties', 'properties.id = orders.property_id', 'left')
            ->join('users as buyer', 'buyer.id = orders.buyer_id', 'left')
            ->where('orders.seller_id', (int) $userId)
            ->where('orders.status', 'paid')
            ->orderBy('orders.created_at', 'DESC')
            ->limit(8)
            ->findAll();

        return view('seller/dashboard', [
            'user' => $user,
            'properties' => $properties,
            'totalProperties' => $totalProperties,
            'totalActive' => $totalActive,
            'totalSold' => $totalSold,
            'totalRevenue' => $totalRevenue,
            'totalViews' => $totalViews,
            'totalMessages' => $totalMessages,
            'statusCounts' => $statusCounts,
            'monthlyStats' => array_values($monthlyStats),
            'recentOrders' => $recentOrders,
        ]);
    }

    public function sellInfo()
    {
        $user = $this->isLoggedIn() ? $this->userModel->find(session()->get('user_id')) : null;

        if ($user && in_array($user['role'], ['seller', 'admin'])) {
            return redirect()->to('/seller/properti/tambah');
        }

        return view('seller/sell_info', [
            'user' => $user,
        ]);
    }

    public function subscription()
    {
        $user = $this->isLoggedIn() ? $this->userModel->find(session()->get('user_id')) : null;

        return view('seller/subscription', [
            'user' => $user,
        ]);
    }

    public function create()
    {
        $this->requireLogin();
        $this->requireRole(['seller', 'admin']);

        $user = $this->userModel->find(session()->get('user_id'));
        $subscriptionStatus = $user['subscription_status'] ?? 'free';
        $uploadCount = $user['upload_count'] ?? 0;

        if ($user['role'] === 'seller' && $subscriptionStatus === 'free' && $uploadCount >= 2) {
            return redirect()->to('/langganan')->with('error', 'Kuota gratis Anda telah habis. Silakan berlangganan untuk mengupload properti tanpa batas.');
        }

        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
                'title' => 'required|min_length[10]|max_length[150]',
                'description' => 'required|min_length[30]',
                'price' => 'required|numeric',
                'type' => 'required|in_list[rumah,kontrakan,apartemen,kost,ruko,tanah]',
                'city' => 'required|min_length[2]|max_length[100]',
                'province' => 'required|min_length[2]|max_length[100]',
                'address' => 'required',
                'garage' => 'permit_empty|integer',
                'contact_name' => 'required|min_length[2]|max_length[100]',
                'contact_email' => 'required|valid_email',
                'whatsapp_number' => 'required|regex_match[/^\+?[0-9]{8,15}$/]',
                'amenities' => 'permit_empty|string',
                'images' => 'permit_empty|max_size[images,' . MAX_UPLOAD_SIZE . ']|ext_in[images,jpg,jpeg,png]|is_image[images]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            try {
                $propertyId = $this->propertyModel->insert([
                    'user_id' => session()->get('user_id'),
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'price' => $this->request->getPost('price'),
                    'type' => $this->request->getPost('type'),
                    'status' => $this->request->getPost('status') ?? 'dijual',
                    'city' => $this->request->getPost('city'),
                    'province' => $this->request->getPost('province'),
                    'address' => $this->request->getPost('address'),
                    'bedrooms' => $this->request->getPost('bedrooms'),
                    'bathrooms' => $this->request->getPost('bathrooms'),
                    'garage' => $this->request->getPost('garage'),
                    'land_area' => $this->request->getPost('land_area'),
                    'building_area' => $this->request->getPost('building_area'),
                    'contact_name' => $this->request->getPost('contact_name'),
                    'contact_email' => $this->request->getPost('contact_email'),
                    'whatsapp_number' => $this->request->getPost('whatsapp_number'),
                    'amenities' => $this->request->getPost('amenities'),
                    'is_active' => 1,
                ]);
            } catch (\Throwable $e) {
                log_message('error', 'CREATE PROPERTY ERROR: ' . $e->getMessage() . ' | POST: ' . json_encode($this->request->getPost()) . ' | USER_ID: ' . session()->get('user_id'));
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan properti. Silakan cek kembali data dan hubungi admin jika perlu.');
            }

            if (!$propertyId) {
                log_message('error', 'CREATE PROPERTY FAILED WITHOUT ID: POST: ' . json_encode($this->request->getPost()) . ' | USER_ID: ' . session()->get('user_id'));
                return redirect()->back()->withInput()->with('error', 'Gagal membuat properti.');
            }

            if ($user['role'] === 'seller') {
                $this->userModel->update($user['id'], ['upload_count' => ($user['upload_count'] ?? 0) + 1]);
            }

            $uploadPath = FCPATH . UPLOAD_PATH . $propertyId . '/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $images = $this->request->getFileMultiple('images');
            $primary = true;
            $primaryImagePath = null;

            foreach ($images as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $tmpPath = $uploadPath . $newName;
                    if ($img->move($uploadPath, $newName)) {
                        resizeImageToMax($tmpPath, $tmpPath, 1200);
                        $imagePath = UPLOAD_PATH . $propertyId . '/' . $newName;
                        $this->propertyImageModel->insert([
                            'property_id' => $propertyId,
                            'image_path' => $imagePath,
                            'is_primary' => $primary ? 1 : 0,
                        ]);

                        log_message('debug', 'CREATE PROPERTY IMAGE SAVED: ' . $imagePath . ' | PROPERTY_ID: ' . $propertyId . ' | USER_ID: ' . session()->get('user_id'));

                        if ($primary) {
                            $primaryImagePath = $tmpPath;
                            $primary = false;
                        }
                    } else {
                        log_message('error', 'CREATE PROPERTY IMAGE UPLOAD FAILED: ' . print_r($img->getError(), true) . ' | PROPERTY_ID: ' . $propertyId . ' | USER_ID: ' . session()->get('user_id'));
                    }
                }
            }

            return redirect()->to('/seller/dashboard')->with('success', 'Properti berhasil ditambahkan.');
        }

        return view('seller/create');
    }

    public function edit($id)
    {
        $this->requireLogin();
        $this->requireRole(['seller', 'admin']);

        $property = $this->propertyModel->where('id', $id)->where('user_id', session()->get('user_id'))->first();
        if (!$property) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
                'title' => 'required|min_length[10]|max_length[150]',
                'description' => 'required|min_length[30]',
                'price' => 'required|numeric',
                'type' => 'required|in_list[rumah,kontrakan,apartemen,kost,ruko,tanah]',
                'city' => 'required|min_length[2]|max_length[100]',
                'province' => 'required|min_length[2]|max_length[100]',
                'address' => 'required',
                'garage' => 'permit_empty|integer',
                'contact_name' => 'required|min_length[2]|max_length[100]',
                'contact_email' => 'required|valid_email',
                'whatsapp_number' => 'required|regex_match[/^\+?[0-9]{8,15}$/]',
                'amenities' => 'permit_empty|string',
                'images' => 'permit_empty|max_size[images,' . MAX_UPLOAD_SIZE . ']|ext_in[images,jpg,jpeg,png]|is_image[images]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            try {
                $this->propertyModel->update($id, [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'price' => $this->request->getPost('price'),
                    'type' => $this->request->getPost('type'),
                    'status' => $this->request->getPost('status') ?? 'dijual',
                    'city' => $this->request->getPost('city'),
                    'province' => $this->request->getPost('province'),
                    'address' => $this->request->getPost('address'),
                    'bedrooms' => $this->request->getPost('bedrooms'),
                    'bathrooms' => $this->request->getPost('bathrooms'),
                    'garage' => $this->request->getPost('garage'),
                    'land_area' => $this->request->getPost('land_area'),
                    'building_area' => $this->request->getPost('building_area'),
                    'contact_name' => $this->request->getPost('contact_name'),
                    'contact_email' => $this->request->getPost('contact_email'),
                    'whatsapp_number' => $this->request->getPost('whatsapp_number'),
                    'amenities' => $this->request->getPost('amenities'),
                ]);
            } catch (\Throwable $e) {
                log_message('error', 'UPDATE PROPERTY ERROR: ' . $e->getMessage() . ' | POST: ' . json_encode($this->request->getPost()) . ' | USER_ID: ' . session()->get('user_id') . ' | PROPERTY_ID: ' . $id);
                return redirect()->back()->withInput()->with('error', 'Gagal memperbarui properti. Silakan cek kembali data.');
            }

            $images = $this->request->getFileMultiple('images');
            if (!empty($images) && $images[0]->isValid()) {
                // Jika ada upload baru, pastikan foto baru bisa menjadi primary
                $this->propertyImageModel->where('property_id', $id)->set(['is_primary' => 0])->update();

                $uploadPath = FCPATH . UPLOAD_PATH . $id . '/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $primary = true;
                foreach ($images as $img) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $tmpPath = $uploadPath . $newName;
                        if ($img->move($uploadPath, $newName)) {
                            resizeImageToMax($tmpPath, $tmpPath, 1200);
                            $imagePath = UPLOAD_PATH . $id . '/' . $newName;
                            $this->propertyImageModel->insert([
                                'property_id' => $id,
                                'image_path' => $imagePath,
                                'is_primary' => $primary ? 1 : 0,
                            ]);
                            $primary = false;
                            log_message('debug', 'UPDATE PROPERTY IMAGE SAVED: ' . $imagePath . ' | PROPERTY_ID: ' . $id . ' | USER_ID: ' . session()->get('user_id'));
                        } else {
                            log_message('error', 'UPDATE PROPERTY IMAGE UPLOAD FAILED: ' . print_r($img->getError(), true) . ' | PROPERTY_ID: ' . $id . ' | USER_ID: ' . session()->get('user_id'));
                        }
                    }
                }

            }

            return redirect()->to('/seller/dashboard')->with('success', 'Properti berhasil diperbarui.');
        }

        return view('seller/edit', ['property' => $property, 'images' => $this->propertyImageModel->getByProperty($id)]);
    }

    public function delete($id)
    {
        $this->requireLogin();
        $this->requireRole('seller');

        $property = $this->propertyModel->where('id', $id)->where('user_id', session()->get('user_id'))->first();
        if (!$property) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $images = $this->propertyImageModel->where('property_id', $id)->findAll();
        foreach ($images as $img) {
            $path = resolveImageStoragePath($img['image_path']);
            if ($path && file_exists($path)) {
                unlink($path);
            }
            $this->propertyImageModel->delete($img['id']);
        }

        try {
            $deleted = $this->propertyModel->delete($id, true);
            if (! $deleted) {
                throw new \Exception('Gagal menghapus properti dari database.');
            }
        } catch (\Throwable $e) {
            log_message('error', 'DELETE PROPERTY FAILED: ' . $e->getMessage() . ' | PROPERTY_ID: ' . $id . ' | USER_ID: ' . session()->get('user_id'));
            return redirect()->back()->with('error', 'Gagal menghapus properti. Silakan coba lagi atau hubungi admin.');
        }

        return redirect()->to('/seller/dashboard')->with('success', 'Properti berhasil dihapus.');
    }

    public function deleteImage($imageId)
    {
        $this->requireLogin();
        $this->requireRole('seller');

        $image = $this->propertyImageModel->find($imageId);
        if (!$image) {
            return $this->response->setJSON(['success' => false, 'message' => 'Foto tidak ditemukan.']);
        }

        $property = $this->propertyModel->where('id', $image['property_id'])->where('user_id', session()->get('user_id'))->first();
        if (!$property) {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak.']);
        }

        $path = resolveImageStoragePath($image['image_path']);
        if ($path && file_exists($path)) {
            unlink($path);
        }

        $this->propertyImageModel->delete($imageId);

        return $this->response->setJSON(['success' => true, 'message' => 'Foto berhasil dihapus.']);
    }
}
