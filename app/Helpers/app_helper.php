<?php

if (!function_exists('formatRupiah')) {
    function formatRupiah($number): string
    {
        return 'Rp ' . number_format((float) $number, 0, ',', '.');
    }
}

if (!function_exists('timeAgo')) {
    function timeAgo(string $datetime): string
    {
        $time = strtotime($datetime);
        if ($time === false) {
            return 'baru saja';
        }

        $diff = time() - $time;
        $units = [
            31536000 => 'tahun',
            2592000 => 'bulan',
            604800 => 'minggu',
            86400 => 'hari',
            3600 => 'jam',
            60 => 'menit',
            1 => 'detik',
        ];

        foreach ($units as $value => $label) {
            $count = intdiv($diff, $value);
            if ($count >= 1) {
                return $count . ' ' . $label . ($count > 1 ? '' : '') . ' lalu';
            }
        }

        return 'baru saja';
    }
}

if (!function_exists('formatWhatsApp')) {
    function formatWhatsApp(string $number): string
    {
        $number = preg_replace('/[^0-9]/', '', $number) ?? '';
        if ($number === '') {
            return '';
        }

        return '62' . ltrim($number, '0');
    }
}

if (!function_exists('truncateText')) {
    function truncateText(string $text, int $length = 100): string
    {
        $text = trim(strip_tags($text));
        if (mb_strlen($text) <= $length) {
            return $text;
        }

        return rtrim(mb_substr($text, 0, $length, 'UTF-8')) . '...';
    }
}

if (!function_exists('propertyPlaceholder')) {
    function propertyPlaceholder(): string
    {
        return 'https://via.placeholder.com/900x600?text=OMNIHOUSE';
    }
}

if (!function_exists('imageUrl')) {
    function imageUrl(?string $path): string
    {
        if (empty($path)) {
            return propertyPlaceholder();
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $normalized = ltrim($path, '/');
        if (str_starts_with($normalized, 'writable/')) {
            $normalized = substr($normalized, strlen('writable/'));
        }

        return base_url($normalized);
    }
}

if (!function_exists('resolveImageStoragePath')) {
    function resolveImageStoragePath(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        $normalized = ltrim($path, '/');
        if (str_starts_with($normalized, 'writable/')) {
            $normalized = substr($normalized, strlen('writable/'));
            $writablePath = WRITEPATH . $normalized;
            if (file_exists($writablePath)) {
                return $writablePath;
            }
        }

        $publicPath = FCPATH . $normalized;
        if (file_exists($publicPath)) {
            return $publicPath;
        }

        return $publicPath;
    }
}

if (!function_exists('resizeImageToMax')) {
    function resizeImageToMax(string $sourcePath, string $destinationPath, int $maxSize = 1200): bool
    {
        if (!file_exists($sourcePath) || !function_exists('imagecreatefromstring')) {
            return false;
        }

        $data = file_get_contents($sourcePath);
        if ($data === false) {
            return false;
        }

        $image = @imagecreatefromstring($data);
        if ($image === false) {
            return false;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $ratio = min($maxSize / $width, $maxSize / $height);

        if ($ratio >= 1) {
            return copy($sourcePath, $destinationPath);
        }

        $newWidth = (int) round($width * $ratio);
        $newHeight = (int) round($height * $ratio);
        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($resized, true);
        imagesavealpha($resized, true);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $ext = strtolower(pathinfo($destinationPath, PATHINFO_EXTENSION));
        $success = false;
        if ($ext === 'png') {
            $success = imagepng($resized, $destinationPath, 8);
        } else {
            $success = imagejpeg($resized, $destinationPath, 90);
        }

        imagedestroy($image);
        imagedestroy($resized);

        return $success;
    }
}

if (!function_exists('getPopularCities')) {
    function getPopularCities(): array
    {
        $cache = service('cache');

        return $cache->remember('omnihouse_popular_cities', 3600, function () {
            return CITIES;
        });
    }
}
