<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="OMNIHOUSE marketplace properti modern dengan Bootstrap 5.">
    <title><?= esc($title ?? 'OMNIHOUSE') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="<?= base_url('assets/img/favicon.svg') ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <style>
        html, body { min-height: 100%; }
        body {
            background-color: #f5f7fb;
            font-family: Arial, sans-serif;
        }
        .navbar-brand { letter-spacing: 0.08em; }
        .card:hover { transform: translateY(-2px); transition: transform .2s ease; }
        .footer-link { color: #cfd8e3; text-decoration: none; }
        .footer-link:hover { color: #fff; }
        .sticky-top { position: sticky !important; }
    </style>
</head>
<body>
    <?= $this->include('components/navbar') ?>

    <main class="pb-5">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('components/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
