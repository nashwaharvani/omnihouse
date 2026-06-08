<?php

namespace App\Controllers;

use App\Models\MessageModel;
use App\Models\PropertyImageModel;
use App\Models\PropertyModel;

class PropertyController extends BaseController
{
    protected $propertyModel;
    protected $propertyImageModel;
    protected $messageModel;

    public function __construct()
    {
        $this->propertyModel      = new PropertyModel();
        $this->propertyImageModel = new PropertyImageModel();
        $this->messageModel       = new MessageModel();
    }

    public function detail($id)
    {
        $property = $this->propertyModel->find($id);

        if (!$property || (int) $property['is_active'] !== 1) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->propertyModel->incrementView($id);

        $images = $this->propertyImageModel->getByProperty($id);

        $related = $this->propertyModel
            ->where('id !=', $id)
            ->where('type', $property['type'])
            ->where('city', $property['city'])
            ->where('is_active', 1)
            ->limit(4)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $waNumber = preg_replace('/^0/', '62', $property['whatsapp_number']);
        $waLink   = 'https://wa.me/' . $waNumber . '?text=' . urlencode('Halo, saya tertarik dengan properti ' . $property['title'] . ' di OMNIHOUSE');

        return view('property/detail', [
            'property'           => $property,
            'images'             => $images,
            'relatedProperties'  => $related,
            'waLink'             => $waLink,
        ]);
    }

    public function contact($id)
    {
        if (!$this->isLoggedIn()) {
            return $this->response->setJSON([
                'success'  => false,
                'redirect' => '/login',
            ]);
        }

        $message = $this->request->getPost('message');

        $property = $this->propertyModel->find($id);

        if (!$property) {
            return $this->response->setJSON(['success' => false, 'message' => 'Properti tidak ditemukan.']);
        }

        $this->messageModel->insert([
            'property_id'   => $id,
            'sender_id'     => session()->get('user_id'),
            'receiver_id'   => $property['user_id'],
            'message'       => $message,
            'is_read'       => 0,
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Pesan terkirim',
        ]);
    }
}
