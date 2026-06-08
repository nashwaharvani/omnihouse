<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session   = session();
    }

    public function index()
    {
        if ($this->isLoggedIn()) {
            $role = $this->session->get('role');
            if (in_array($role, ['seller', 'admin'], true)) {
                return redirect()->to('/seller/dashboard');
            }

            return redirect()->to('/user/dashboard');
        }

        return redirect()->to('/login');
    }

    public function login()
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required|min_length[6]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $this->userModel->findByEmail($email);

            if (!$user || !password_verify($password, $user['password'])) {
                return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
            }

            $this->session->set([
                'user_id' => $user['id'],
                'name'    => $user['name'],
                'email'   => $user['email'],
                'role'    => $user['role'],
            ]);

            $next = $this->request->getPost('next');
            $allowedNext = '/seller/properti/tambah';
            $redirectUrl = '/';

            if ($next && $next === $allowedNext && in_array($user['role'], ['seller', 'admin'], true)) {
                $redirectUrl = $next;
            } elseif (in_array($user['role'], ['seller', 'admin'], true)) {
                $redirectUrl = '/seller/dashboard';
            }

            return redirect()->to($redirectUrl)->with('success', 'Login berhasil.');
        }

        return view('auth/login');
    }

    public function register()
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
                'name'     => 'required|min_length[2]|max_length[100]',
                'email'    => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[password]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $role = $this->request->getPost('role') ?? $this->request->getGet('role');
            if (!in_array($role, ['buyer', 'seller'], true)) {
                $role = 'buyer';
            }

            $data = [
                'name'                => $this->request->getPost('name'),
                'email'               => strtolower($this->request->getPost('email')),
                'password'            => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role'                => $role,
                'subscription_status' => 'free',
                'upload_count'        => 0,
            ];

            $userId = $this->userModel->insert($data);

            if (!$userId) {
                return redirect()->back()->withInput()->with('error', 'Gagal membuat akun.');
            }

            if ($role === 'seller') {
                return redirect()->to('/login?next=' . urlencode('/seller/properti/tambah'))->with('success', 'Akun penjual berhasil dibuat. Silakan login untuk melanjutkan ke unggah properti.');
            }

            return redirect()->to('/login')->with('success', 'Akun berhasil dibuat. Silakan login.');
        }

        return view('auth/register');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/')->with('success', 'Anda telah logout.');
    }
}
