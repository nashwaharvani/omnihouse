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
                return redirect()->to('/dashboard/seller');
            }

            return redirect()->to('/dashboard/buyer');
        }

        return redirect()->to('/login');
    }

    public function login()
    {
        return redirect()->to('/login/buyer');
    }

    public function loginBuyer()
    {
        if ($this->isLoggedIn()) {
            if (in_array($this->session->get('role'), ['seller', 'admin'], true)) {
                return redirect()->to('/dashboard/seller');
            }

            return redirect()->to('/dashboard/buyer');
        }

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

            if ($user['role'] !== 'buyer') {
                return redirect()->back()->withInput()->with('error', 'Silakan gunakan halaman login penjual untuk akun ini.');
            }

            $this->setUserSession($user);

            return redirect()->to('/dashboard/buyer')->with('success', 'Login berhasil. Selamat datang!');
        }

        return view('auth/login_buyer');
    }

    public function loginSeller()
    {
        if ($this->isLoggedIn()) {
            if (in_array($this->session->get('role'), ['seller', 'admin'], true)) {
                return redirect()->to('/dashboard/seller');
            }

            return redirect()->to('/dashboard/buyer');
        }

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
            $next     = $this->request->getPost('next');

            $user = $this->userModel->findByEmail($email);
            if (!$user || !password_verify($password, $user['password'])) {
                return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
            }

            if (!in_array($user['role'], ['seller', 'admin'], true)) {
                return redirect()->back()->withInput()->with('error', 'Silakan gunakan halaman login pembeli untuk akun ini.');
            }

            $this->setUserSession($user);

            if ($next && str_starts_with($next, '/seller')) {
                return redirect()->to($next)->with('success', 'Login berhasil. Selamat datang, Seller!');
            }

            return redirect()->to('/dashboard/seller')->with('success', 'Login berhasil. Selamat datang, Seller!');
        }

        return view('auth/login_seller');
    }

    public function register()
    {
        return redirect()->to('/register/buyer');
    }

    public function registerBuyer()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('/dashboard/buyer');
        }

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

            $data = [
                'name'                => $this->request->getPost('name'),
                'email'               => strtolower($this->request->getPost('email')),
                'password'            => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role'                => 'buyer',
                'subscription_status' => 'free',
                'upload_count'        => 0,
            ];

            $userId = $this->userModel->insert($data);

            if (!$userId) {
                return redirect()->back()->withInput()->with('error', 'Gagal membuat akun.');
            }

            return redirect()->to('/login/buyer')->with('success', 'Akun buyer berhasil dibuat. Silakan login.');
        }

        return view('auth/register_buyer');
    }

    public function registerSeller()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('/dashboard/seller');
        }

        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
                'name'             => 'required|min_length[2]|max_length[100]',
                'email'            => 'required|valid_email|is_unique[users.email]',
                'password'         => 'required|min_length[6]',
                'confirm_password' => 'required|matches[password]',
                'phone'            => 'required|max_length[20]',
                'agency_name'      => 'permit_empty|max_length[150]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'name'                => $this->request->getPost('name'),
                'email'               => strtolower($this->request->getPost('email')),
                'password'            => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role'                => 'seller',
                'phone'               => $this->request->getPost('phone'),
                'agency_name'         => $this->request->getPost('agency_name'),
                'subscription_status' => 'free',
                'upload_count'        => 0,
            ];

            $userId = $this->userModel->insert($data);

            if (!$userId) {
                return redirect()->back()->withInput()->with('error', 'Gagal membuat akun penjual.');
            }

            return redirect()->to('/login/seller?next=' . urlencode('/seller/properti/tambah'))->with('success', 'Akun seller berhasil dibuat. Silakan login sekarang.');
        }

        return view('auth/register_seller');
    }

    private function setUserSession(array $user): void
    {
        $this->session->set([
            'user_id' => $user['id'],
            'name'    => $user['name'],
            'email'   => $user['email'],
            'role'    => $user['role'],
        ]);
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/')->with('success', 'Anda telah logout.');
    }
}
