<?php

namespace App\Controllers;

use App\Models\PropertyModel;

class HomeController extends BaseController
{
    protected $propertyModel;

    public function __construct()
    {
        $this->propertyModel = new PropertyModel();
    }

    public function index()
    {
        $properties = $this->propertyModel->getLatestProperties(8);
        $cities     = getPopularCities();

        return view('home/index', [
            'properties' => $properties,
            'cities'     => $cities,
        ]);
    }

    public function search()
    {
        $keyword   = trim($this->request->getGet('keyword') ?? '');
        $city      = trim($this->request->getGet('city') ?? '');
        $type      = trim($this->request->getGet('type') ?? '');
        $status    = trim($this->request->getGet('status') ?? '');
        $priceMin  = trim($this->request->getGet('price_min') ?? '');
        $priceMax  = trim($this->request->getGet('price_max') ?? '');
        $bedrooms  = trim($this->request->getGet('bedrooms') ?? '');

        if (! $city || ! $type) {
            $parsed = $this->parseSearchKeyword($keyword);
            if (! $city && ! empty($parsed['city'])) {
                $city = $parsed['city'];
            }
            if (! $type && ! empty($parsed['type'])) {
                $type = $parsed['type'];
            }
        }

        $filters = [
            'city'      => $city,
            'type'      => $type,
            'status'    => $status,
            'min_price' => $priceMin,
            'max_price' => $priceMax,
            'bedrooms'  => $bedrooms,
        ];

        $page = (int) ($this->request->getGet('page') ?? 1);

        $builder = $this->propertyModel->searchProperties($keyword, $filters);
        $total   = count($builder);

        $pager = service('pager');
        $perPage = 10;

        $pageData = array_slice($builder, ($page - 1) * $perPage, $perPage);

        return view('home/search', [
            'properties' => $pageData,
            'pager'      => $pager->makeLinks($page, $perPage, $total, 'default_full'),
            'filters'    => $filters,
            'keyword'    => $keyword,
            'total'      => $total,
            'bedrooms'   => $bedrooms,
        ]);
    }

    private function parseSearchKeyword(string $keyword): array
    {
        $keyword = strtolower(trim($keyword));
        if ($keyword === '') {
            return ['type' => '', 'city' => ''];
        }

        $types = ['rumah', 'kontrakan', 'apartemen', 'kost', 'ruko', 'tanah'];
        $tokens = preg_split('/[^a-z0-9]+/i', $keyword, -1, PREG_SPLIT_NO_EMPTY);
        $parsedType = '';
        $parsedCity = [];

        foreach ($tokens as $token) {
            if (in_array($token, $types, true)) {
                $parsedType = $token;
                continue;
            }

            if (in_array($token, ['dijual', 'disewa'], true)) {
                continue;
            }

            $parsedCity[] = $token;
        }

        return [
            'type' => $parsedType,
            'city' => implode(' ', $parsedCity),
        ];
    }
}
