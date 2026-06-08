<?php

namespace App\Controllers;

use App\Models\MessageModel;
use App\Models\PropertyModel;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $propertyModel;
    protected $messageModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->propertyModel = new PropertyModel();
        $this->messageModel = new MessageModel();
    }

    public function dashboard()
    {
        $this->requireLogin();

        if (session()->get('role') === 'seller' || session()->get('role') === 'admin') {
            return redirect()->to('/dashboard/seller');
        }

        $userId = session()->get('user_id');
        $messages = $this->messageModel->where('sender_id', $userId)->orderBy('created_at', 'DESC')->findAll();
        $recommendedProperties = $this->propertyModel->getLatestProperties(6);

        return view('user/dashboard', [
            'messages' => $messages,
            'recommendedProperties' => $recommendedProperties,
        ]);
    }

    public function favorites()
    {
        $this->requireLogin();

        if (session()->get('role') === 'seller' || session()->get('role') === 'admin') {
            return redirect()->to('/dashboard/seller')->with('error', 'Akses ditolak. Halaman ini hanya untuk pembeli.');
        }

        return view('user/favorites');
    }

    public function profile()
    {
        $this->requireLogin();

        $user = $this->userModel->find(session()->get('user_id'));

        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
                'name' => 'required|min_length[2]|max_length[100]',
                'email' => 'required|valid_email|is_unique[users.email,id,' . $user['id'] . ']',
                'avatar' => 'max_size[avatar,2048]|ext_in[avatar,jpg,jpeg,png]|is_image[avatar]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'email' => strtolower($this->request->getPost('email')),
                'phone' => $this->request->getPost('phone'),
            ];

            $avatar = $this->request->getFile('avatar');
            if ($avatar && $avatar->isValid() && !$avatar->hasMoved()) {
                $dir = WRITEPATH . 'uploads/avatars/';
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }

                $name = $avatar->getRandomName();
                $target = $dir . $name;
                if ($avatar->move($dir, $name)) {
                    resizeImageToMax($target, $target, 1200);
                    $data['avatar'] = 'writable/uploads/avatars/' . $name;
                }
            }

            if ($this->request->getPost('password')) {
                if (!password_verify($this->request->getPost('old_password'), $user['password'])) {
                    return redirect()->back()->withInput()->with('error', 'Password lama salah.');
                }
                if (strlen($this->request->getPost('password')) < 6) {
                    return redirect()->back()->withInput()->with('error', 'Password baru minimal 6 karakter.');
                }
                $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            }

            $this->userModel->update($user['id'], $data);
            return redirect()->to('/user/profile')->with('success', 'Profil berhasil diperbarui.');
        }

        return view('user/profile', ['user' => $user]);
    }

    public function inbox()
    {
        $this->requireLogin();

        $userId = session()->get('user_id');
        $messages = $this->messageModel
            ->select('messages.*, properties.title as property_title, sender.name as sender_name, receiver.name as receiver_name')
            ->join('properties', 'properties.id = messages.property_id', 'left')
            ->join('users as sender', 'sender.id = messages.sender_id', 'left')
            ->join('users as receiver', 'receiver.id = messages.receiver_id', 'left')
            ->where('messages.sender_id', $userId)
            ->orWhere('messages.receiver_id', $userId)
            ->orderBy('messages.created_at', 'DESC')
            ->findAll();

        $conversations = [];
        foreach ($messages as $msg) {
            $otherId = ($msg['sender_id'] == $userId) ? $msg['receiver_id'] : $msg['sender_id'];
            $key = $msg['property_id'] . '-' . $otherId;
            if (!isset($conversations[$key])) {
                $conversations[$key] = [
                    'property_id' => $msg['property_id'],
                    'property_title' => $msg['property_title'],
                    'other_id' => $otherId,
                    'other_name' => ($msg['sender_id'] == $userId) ? $msg['receiver_name'] : $msg['sender_name'],
                    'last_message' => $msg['message'],
                    'last_time' => $msg['created_at'],
                    'unread' => 0,
                ];
            }
            if ($msg['receiver_id'] == $userId && $msg['is_read'] == 0) {
                $conversations[$key]['unread']++;
            }
        }

        return view('user/inbox', [
            'conversations' => $conversations,
        ]);
    }

    public function conversation($propertyId, $userId)
    {
        $this->requireLogin();

        $currentUserId = session()->get('user_id');
        $this->messageModel->where('property_id', $propertyId)
            ->where('receiver_id', $currentUserId)
            ->where('sender_id', $userId)
            ->where('is_read', 0)
            ->set('is_read', 1)
            ->update();

        $thread = $this->messageModel->getConversation($propertyId, $currentUserId, $userId);
        $property = $this->propertyModel->find($propertyId);
        $other = $this->userModel->find($userId);

        return view('user/conversation', [
            'property' => $property,
            'other' => $other,
            'thread' => $thread,
        ]);
    }

    public function sendMessage()
    {
        $this->requireLogin();

        $propertyId = $this->request->getPost('property_id');
        $receiverId = $this->request->getPost('receiver_id');
        $message = $this->request->getPost('message');

        $id = $this->messageModel->insert([
            'property_id' => $propertyId,
            'sender_id' => session()->get('user_id'),
            'receiver_id' => $receiverId,
            'message' => $message,
            'is_read' => 0,
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => [
                'id' => $id,
                'text' => $message,
                'time' => date('H:i'),
            ],
        ]);
    }
}
