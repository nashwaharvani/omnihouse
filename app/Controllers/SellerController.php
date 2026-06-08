<?php

namespace App\Controllers;

use App\Models\PropertyImageModel;
use App\Models\PropertyModel;
use App\Models\MessageModel;
use App\Models\UserModel;


class SellerController extends BaseController
{
    protected $propertyModel;
    protected $propertyImageModel;
    protected $messageModel;
    protected $userModel;

    public function __construct()
    {
        $this->propertyModel = new PropertyModel();
        $this->propertyImageModel = new PropertyImageModel();
        $this->messageModel = new MessageModel();
        $this->userModel = new UserModel();
    }

    public function dashboard()
    {
        $this->requireLogin();
        $this->requireRole(['seller', 'admin']);

        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $properties = $this->propertyModel->getByUser($userId);
        $totalProperties = count($properties);
        $totalViews = array_sum(array_column($properties, 'views'));
        $totalMessages = $this->messageModel->where('receiver_id', $userId)->countAllResults();

        return view('seller/dashboard', [
            'user' => $user,
            'properties' => $properties,
            'totalProperties' => $totalProperties,
            'totalViews' => $totalViews,
            'totalMessages' => $totalMessages,
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
                'images' => 'uploaded[images]|max_size[images,' . MAX_UPLOAD_SIZE . ']|ext_in[images,jpg,jpeg,png]|is_image[images]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

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

            if (!$propertyId) {
                return redirect()->back()->withInput()->with('error', 'Gagal membuat properti.');
            }

            if ($user['role'] === 'seller') {
                $this->userModel->update($user['id'], ['upload_count' => ($user['upload_count'] ?? 0) + 1]);
            }

            $uploadPath = WRITEPATH . 'uploads/properties/' . $propertyId . '/';
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
                    }
                    $this->propertyImageModel->insert([
                        'property_id' => $propertyId,
                        'image_path' => 'writable/uploads/properties/' . $propertyId . '/' . $newName,
                        'is_primary' => $primary ? 1 : 0,
                    ]);

                    if ($primary) {
                        $primaryImagePath = $tmpPath;
                        $primary = false;
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
                'images' => 'max_size[images,' . MAX_UPLOAD_SIZE . ']|ext_in[images,jpg,jpeg,png]|is_image[images]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

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

            $images = $this->request->getFileMultiple('images');
            if (!empty($images) && $images[0]->isValid()) {
                $uploadPath = WRITEPATH . 'uploads/properties/' . $id . '/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                foreach ($images as $img) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $tmpPath = $uploadPath . $newName;
                        if ($img->move($uploadPath, $newName)) {
                            resizeImageToMax($tmpPath, $tmpPath, 1200);
                        }
                        $this->propertyImageModel->insert([
                            'property_id' => $id,
                            'image_path' => 'writable/uploads/properties/' . $id . '/' . $newName,
                            'is_primary' => 0,
                        ]);
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
            $path = WRITEPATH . str_replace('writable/', '', $img['image_path']);
            if (file_exists($path)) {
                unlink($path);
            }
            $this->propertyImageModel->delete($img['id']);
        }

        $this->propertyModel->update($id, ['is_active' => 0]);

        return redirect()->to('/seller/dashboard')->with('success', 'Properti berhasil dinonaktifkan.');
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

        $path = WRITEPATH . str_replace('writable/', '', $image['image_path']);
        if (file_exists($path)) {
            unlink($path);
        }

        $this->propertyImageModel->delete($imageId);

        return $this->response->setJSON(['success' => true, 'message' => 'Foto berhasil dihapus.']);
    }
}
