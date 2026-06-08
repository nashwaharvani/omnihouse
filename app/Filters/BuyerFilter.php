<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class BuyerFilter extends AuthFilter
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $result = parent::before($request, $arguments);
        if ($result !== null) {
            return $result;
        }

        $session = session();
        if ($session->get('role') !== 'buyer') {
            if (in_array($session->get('role'), ['seller', 'admin'], true)) {
                return redirect()->to('/dashboard/seller')->with('error', 'Akses ditolak. Halaman ini hanya untuk pembeli.');
            }

            return redirect()->to('/login')->with('error', 'Silakan login sebagai pembeli untuk mengakses halaman ini.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response;
    }
}
