<?php $title = 'Pemesanan - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Pemesanan Saya</h2>
                <p class="text-muted mb-0">Daftar pemesanan DP atau pelunasan yang pernah Anda buat.</p>
            </div>
            <a href="<?= site_url('search') ?>" class="btn btn-outline-primary">Cari Properti</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success rounded-4"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger rounded-4"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="card rounded-4 shadow-sm p-4">
            <?php if (empty($orders)): ?>
                <div class="text-center py-5 text-muted">Belum ada pemesanan.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                        <tr>
                            <th>Properti</th>
                            <th>Penjual</th>
                            <th>Jenis Bayar</th>
                            <th>Metode</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold">
                                        <a href="<?= site_url('properti/' . (int) $order['property_id']) ?>"><?= esc($order['property_title'] ?? '-') ?></a>
                                    </div>
                                    <div class="text-muted small"><?= esc($order['property_city'] ?? '') ?></div>
                                </td>
                                <td><?= esc($order['seller_name'] ?? '-') ?></td>
                                <td class="text-capitalize"><?= esc($order['payment_type'] ?? '-') ?></td>
                                <td class="text-capitalize"><?= esc($order['payment_method'] ?? 'simulasi') ?></td>
                                <td><?= formatRupiah((float) ($order['amount'] ?? 0)) ?></td>
                                <td>
                                    <?php $badge = ($order['status'] ?? '') === 'paid' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'; ?>
                                    <span class="badge <?= esc($badge) ?> text-uppercase"><?= esc($order['status'] ?? '-') ?></span>
                                </td>
                                <td class="text-muted"><?= esc($order['created_at'] ?? '-') ?></td>
                                <td class="text-end">
                                    <?php if (($order['payment_type'] ?? '') === 'dp' && ($order['status'] ?? '') === 'paid'): ?>
                                        <form method="post" action="<?= site_url('pemesanan/' . (int) $order['id'] . '/pelunasan') ?>">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="payment_method" value="<?= esc($order['payment_method'] ?? 'simulasi') ?>">
                                            <button type="submit" class="btn btn-outline-primary btn-sm" onclick="return confirm('Lanjutkan pelunasan untuk properti ini?')">Pelunasan</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
