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
            'bodyClass'  => 'page-home',
        ]);
    }

    public function search()
    {
        $keyword = trim($this->request->getGet('keyword') ?? '');
        $sort    = trim($this->request->getGet('sort') ?? 'newest');

        $filters = [
            'city'               => trim($this->request->getGet('city') ?? ''),
            'province'           => trim($this->request->getGet('province') ?? ''),
            'type'               => trim($this->request->getGet('type') ?? ''),
            'status'             => trim($this->request->getGet('status') ?? ''),
            'min_price'          => trim($this->request->getGet('price_min') ?? ''),
            'max_price'          => trim($this->request->getGet('price_max') ?? ''),
            'bedrooms'           => trim($this->request->getGet('bedrooms') ?? ''),
            'bathrooms'          => trim($this->request->getGet('bathrooms') ?? ''),
            'min_land_area'      => trim($this->request->getGet('land_min') ?? ''),
            'max_land_area'      => trim($this->request->getGet('land_max') ?? ''),
            'min_building_area'  => trim($this->request->getGet('building_min') ?? ''),
            'max_building_area'  => trim($this->request->getGet('building_max') ?? ''),
            'sort'               => in_array($sort, ['newest', 'price_asc', 'price_desc', 'views'], true) ? $sort : 'newest',
        ];

        $page    = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = 12;
        $results = $this->propertyModel->searchProperties($keyword, $filters);
        $total   = count($results);
        $pager   = service('pager');

        return view('home/search', [
            'properties' => array_slice($results, ($page - 1) * $perPage, $perPage),
            'pager'      => $pager->makeLinks($page, $perPage, $total, 'default_full'),
            'filters'    => $filters,
            'keyword'    => $keyword,
            'total'      => $total,
            'cities'     => getPopularCities(),
        ]);
    }

    public function priceDrop()
    {
        $properties = $this->propertyModel->getAllActiveProperties();
        $discounted = [];

        foreach ($properties as $property) {
            $price = (float) $property['price'];
            $originalPrice = round($price * (1 + rand(10, 18) / 100), -3);
            if ($originalPrice <= $price) {
                $originalPrice = round($price * 1.15, -3);
            }
            $discounted[] = array_merge($property, [
                'original_price' => $originalPrice,
                'discount_pct' => (int) round((($originalPrice - $price) / $originalPrice) * 100),
            ]);
        }

        return view('home/price_drop', [
            'properties' => array_slice($discounted, 0, 12),
        ]);
    }

    public function calculator()
    {
        return view('home/calculator');
    }

    public function community()
    {
        return view('home/community');
    }

    public function services()
    {
        return view('home/services');
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
