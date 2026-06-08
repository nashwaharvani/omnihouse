<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SellerFilter extends AuthFilter
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $result = parent::before($request, $arguments);
        if ($result !== null) {
            return $result;
        }

        $session = session();
        if (!in_array($session->get('role'), ['seller', 'admin'], true)) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response;
    }
}
