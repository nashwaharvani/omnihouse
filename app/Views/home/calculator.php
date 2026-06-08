<?php $title = 'Kalkulator Harga - OMNIHOUSE' ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <span class="badge bg-white text-primary mb-3">Kalkulator Cicilan</span>
                <h1 class="display-5 fw-bold">Hitung Cicilan Properti Anda</h1>
                <p class="lead text-white-75">Gunakan kalkulator ini untuk memperkirakan cicilan, total pinjaman, dan total pembayaran berdasarkan harga properti dan suku bunga.</p>
            </div>
            <div class="col-lg-5">
                <div class="card rounded-4 p-4 shadow-sm bg-white text-dark">
                    <h4 class="fw-semibold mb-3">Kalkulator KPR</h4>
                    <div class="mb-3">
                        <label class="form-label">Harga Properti</label>
                        <input id="propertyPrice" type="number" class="form-control" placeholder="Rp" value="1000000000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Uang Muka (%)</label>
                        <input id="downPayment" type="number" class="form-control" placeholder="20" value="20">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lama Cicilan (tahun)</label>
                        <input id="termYears" type="number" class="form-control" placeholder="20" value="15">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Suku Bunga Tahunan (%)</label>
                        <input id="interestRate" type="number" class="form-control" placeholder="7" value="7">
                    </div>
                    <button id="calculateButton" class="btn btn-primary w-100">Hitung Sekarang</button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card rounded-4 shadow-sm p-4">
                    <h5 class="fw-semibold">Cicilan Per Bulan</h5>
                    <p class="fs-3 fw-bold text-primary" id="monthlyPayment">Rp 0</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card rounded-4 shadow-sm p-4">
                    <h5 class="fw-semibold">Total Pinjaman</h5>
                    <p class="fs-3 fw-bold text-primary" id="loanAmount">Rp 0</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card rounded-4 shadow-sm p-4">
                    <h5 class="fw-semibold">Total Pembayaran</h5>
                    <p class="fs-3 fw-bold text-primary" id="totalPayment">Rp 0</p>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h2 class="h4 fw-bold mb-3">Cara Menggunakan Kalkulator</h2>
            <ul class="list-unstyled text-muted">
                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Masukkan harga properti dan persentase uang muka.</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Tentukan jangka waktu cicilan dan suku bunga tahunan.</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Klik tombol hitung untuk melihat estimasi cicilan bulanan.</li>
            </ul>
        </div>
    </div>
</section>

<script>
    function formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value);
    }

    function calculateMortgage() {
        const price = Number(document.getElementById('propertyPrice').value) || 0;
        const downPaymentPercent = Number(document.getElementById('downPayment').value) || 0;
        const termYears = Number(document.getElementById('termYears').value) || 1;
        const interestRate = Number(document.getElementById('interestRate').value) || 0;

        const downPayment = price * (downPaymentPercent / 100);
        const loan = Math.max(price - downPayment, 0);
        const monthlyRate = interestRate / 100 / 12;
        const months = termYears * 12;

        const monthlyPayment = monthlyRate > 0
            ? loan * (monthlyRate / (1 - Math.pow(1 + monthlyRate, -months)))
            : loan / months;

        const totalPayment = loan + monthlyPayment * months;

        document.getElementById('loanAmount').innerText = formatCurrency(loan);
        document.getElementById('monthlyPayment').innerText = formatCurrency(monthlyPayment);
        document.getElementById('totalPayment').innerText = formatCurrency(totalPayment);
    }

    document.getElementById('calculateButton').addEventListener('click', (event) => {
        event.preventDefault();
        calculateMortgage();
    });

    calculateMortgage();
</script>
<?= $this->endSection() ?>
