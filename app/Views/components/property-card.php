<div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
    <?php
    $foto = $property['image'] ?? ($property->image ?? null);
    $foto = imageUrl($foto ?: propertyPlaceholder());
    $tipe = $property['type'] ?? ($property->type ?? 'Properti');
    $status = $property['status'] ?? ($property->status ?? 'Ready');
    $judul = $property['title'] ?? ($property->title ?? 'Judul Properti');
    $kota = $property['city'] ?? ($property->city ?? 'Kota');
    $kamarTidur = $property['bedrooms'] ?? ($property->bedrooms ?? 0);
    $kamarMandi = $property['bathrooms'] ?? ($property->bathrooms ?? 0);
    $harga = $property['price'] ?? ($property->price ?? 0);
    $slug = $property['slug'] ?? ($property->slug ?? '');
    ?>

    <img src="<?= esc($foto) ?>" class="card-img-top" alt="<?= esc($judul) ?>" loading="lazy" style="height: 220px; object-fit: cover;">

    <div class="card-body d-flex flex-column">
        <div class="d-flex justify-content-between gap-2 mb-2">
            <span class="badge bg-primary-subtle text-primary"><?= esc($tipe) ?></span>
            <span class="badge bg-success-subtle text-success"><?= esc($status) ?></span>
        </div>

        <h5 class="card-title mb-2"><?= esc($judul) ?></h5>
        <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i><?= esc($kota) ?></p>

        <div class="row text-muted small mb-3 gx-2">
            <div class="col-6 mb-2"><i class="bi bi-bed me-1"></i><?= (int) $kamarTidur ?> Kamar</div>
            <div class="col-6 mb-2"><i class="bi bi-bathtub me-1"></i><?= (int) $kamarMandi ?> Mandi</div>
            <div class="col-12"><i class="bi bi-aspect-ratio me-1"></i><?= (int) ($property['building_area'] ?? $property->building_area ?? 0) ?> m²</div>
        </div>

        <p class="fw-bold text-primary mb-3">Rp <?= number_format((float) $harga, 0, ',', '.') ?></p>

        <a href="<?= site_url('properti/' . ($property['id'] ?? ($property->id ?? ''))) ?>" class="btn btn-outline-primary mt-auto">Lihat Detail</a>
    </div>
</div>
