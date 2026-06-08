<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\PropertyModel;
use App\Models\UserModel;

class OrdersController extends BaseController
{
    protected $orderModel;
    protected $propertyModel;
    protected $userModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->propertyModel = new PropertyModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $this->requireLogin();

        if (session()->get('role') === 'seller' || session()->get('role') === 'admin') {
            return redirect()->to('/dashboard/seller');
        }

        if (! $this->orderModel->db->tableExists('orders')) {
            session()->setFlashdata('error', 'Fitur pemesanan belum siap. Jalankan migrasi database terlebih dahulu.');
            return view('user/orders', [
                'orders' => [],
            ]);
        }

        $buyerId = (int) session()->get('user_id');

        $orders = $this->orderModel
            ->select('orders.*, properties.title as property_title, properties.city as property_city, users.name as seller_name')
            ->join('properties', 'properties.id = orders.property_id', 'left')
            ->join('users', 'users.id = orders.seller_id', 'left')
            ->where('orders.buyer_id', $buyerId)
            ->orderBy('orders.created_at', 'DESC')
            ->findAll();

        return view('user/orders', [
            'orders' => $orders,
        ]);
    }

    public function create($propertyId)
    {
        $this->requireLogin();

        if (session()->get('role') === 'seller' || session()->get('role') === 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak. Fitur pemesanan hanya untuk pembeli.');
        }

        if (! $this->orderModel->db->tableExists('orders')) {
            return redirect()->back()->with('error', 'Fitur pemesanan belum siap. Jalankan migrasi database terlebih dahulu.');
        }

        $buyerId = (int) session()->get('user_id');
        $propertyId = (int) $propertyId;

        $property = $this->propertyModel->find($propertyId);
        if (!$property || !empty($property['deleted_at'])) {
            return redirect()->back()->with('error', 'Properti tidak ditemukan.');
        }

        if ((int) ($property['is_active'] ?? 0) !== 1) {
            return redirect()->back()->with('error', 'Properti ini tidak tersedia untuk dipesan.');
        }

        if (($property['status'] ?? '') === 'dipesan') {
            return redirect()->back()->with('error', 'Properti ini sudah dipesan.');
        }

        $sellerId = (int) ($property['user_id'] ?? 0);
        if ($sellerId === $buyerId) {
            return redirect()->back()->with('error', 'Anda tidak bisa memesan properti milik sendiri.');
        }

        $paymentType = (string) ($this->request->getPost('payment_type') ?? 'dp');
        if (!in_array($paymentType, ['dp', 'pelunasan'], true)) {
            $paymentType = 'dp';
        }

        $paymentMethod = (string) ($this->request->getPost('payment_method') ?? 'simulasi');
        if (!in_array($paymentMethod, ['simulasi', 'transfer', 'cash', 'gateway'], true)) {
            $paymentMethod = 'simulasi';
        }

        $price = (float) ($property['price'] ?? 0);
        $dpRate = defined('ORDER_DP_RATE') ? (float) ORDER_DP_RATE : 0.1;
        $amount = $paymentType === 'pelunasan' ? (int) round($price) : (int) max(1, round($price * $dpRate));

        $existing = $this->orderModel
            ->where('property_id', $propertyId)
            ->whereIn('status', ['paid', 'pending'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Properti ini sudah memiliki pemesanan aktif.');
        }

        $db = $this->orderModel->db;
        $db->transBegin();

        try {
            $orderId = $this->orderModel->insert([
                'property_id' => $propertyId,
                'buyer_id' => $buyerId,
                'seller_id' => $sellerId,
                'payment_type' => $paymentType,
                'payment_method' => $paymentMethod,
                'amount' => $amount,
                'status' => 'paid',
                'paid_at' => date('Y-m-d H:i:s'),
            ], true);

            if (!$orderId) {
                $errors = $this->orderModel->errors();
                $msg = $errors ? implode(' ', $errors) : 'Gagal membuat pemesanan.';
                throw new \RuntimeException($msg);
            }

            $nextStatus = $paymentType === 'pelunasan' ? 'terjual' : 'dipesan';
            $updateData = ['status' => $nextStatus];
            if ($paymentType === 'pelunasan') {
                $updateData['is_active'] = 0;
            }
            $updated = $this->propertyModel->update($propertyId, $updateData);

            if (!$updated) {
                throw new \RuntimeException('Gagal mengubah status properti.');
            }

            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Gagal membuat pemesanan. Pastikan migrasi sudah dijalankan dan coba lagi.');
        }

        return redirect()->to('/user/pemesanan')->with('success', 'Pemesanan berhasil dibuat.');
    }

    public function payOff($orderId)
    {
        $this->requireLogin();

        if (session()->get('role') === 'seller' || session()->get('role') === 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak. Fitur pemesanan hanya untuk pembeli.');
        }

        if (! $this->orderModel->db->tableExists('orders')) {
            return redirect()->back()->with('error', 'Fitur pemesanan belum siap. Jalankan migrasi database terlebih dahulu.');
        }

        $buyerId = (int) session()->get('user_id');
        $orderId = (int) $orderId;

        $order = $this->orderModel->find($orderId);
        if (!$order || (int) ($order['buyer_id'] ?? 0) !== $buyerId) {
            return redirect()->back()->with('error', 'Pemesanan tidak ditemukan.');
        }

        if (($order['payment_type'] ?? '') !== 'dp' || ($order['status'] ?? '') !== 'paid') {
            return redirect()->back()->with('error', 'Pemesanan ini tidak bisa dilunasi.');
        }

        $propertyId = (int) ($order['property_id'] ?? 0);
        $property = $this->propertyModel->find($propertyId);
        if (!$property) {
            return redirect()->back()->with('error', 'Properti tidak ditemukan.');
        }

        if (($property['status'] ?? '') === 'terjual') {
            return redirect()->back()->with('error', 'Properti ini sudah terjual.');
        }

        $existing = $this->orderModel
            ->where('property_id', $propertyId)
            ->where('payment_type', 'pelunasan')
            ->whereIn('status', ['paid', 'pending'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Pelunasan untuk properti ini sudah dibuat.');
        }

        $price = (float) ($property['price'] ?? 0);
        $paidRow = $this->orderModel
            ->selectSum('amount', 'total')
            ->where('property_id', $propertyId)
            ->where('buyer_id', $buyerId)
            ->where('status', 'paid')
            ->first();

        $paidTotal = (float) ($paidRow['total'] ?? 0);
        $remaining = (int) max(0, round($price - $paidTotal));

        if ($remaining <= 0) {
            return redirect()->back()->with('error', 'Tidak ada sisa pembayaran.');
        }

        $sellerId = (int) ($property['user_id'] ?? 0);

        $db = $this->orderModel->db;
        $db->transBegin();

        try {
            $paymentMethod = (string) ($this->request->getPost('payment_method') ?? ($order['payment_method'] ?? 'simulasi'));
            if (!in_array($paymentMethod, ['simulasi', 'transfer', 'cash', 'gateway'], true)) {
                $paymentMethod = 'simulasi';
            }

            $newId = $this->orderModel->insert([
                'property_id' => $propertyId,
                'buyer_id' => $buyerId,
                'seller_id' => $sellerId,
                'payment_type' => 'pelunasan',
                'payment_method' => $paymentMethod,
                'amount' => $remaining,
                'status' => 'paid',
                'paid_at' => date('Y-m-d H:i:s'),
            ], true);

            if (!$newId) {
                throw new \RuntimeException('Gagal membuat pelunasan.');
            }

            $updated = $this->propertyModel->update($propertyId, [
                'status' => 'terjual',
                'is_active' => 0,
            ]);

            if (!$updated) {
                throw new \RuntimeException('Gagal mengubah status properti menjadi terjual.');
            }

            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Gagal melakukan pelunasan. Coba lagi.');
        }

        return redirect()->to('/user/pemesanan')->with('success', 'Pelunasan berhasil. Properti berstatus terjual.');
    }
}
