
<?php
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$isEdit = !empty($product);
$action = $isEdit
    ? 'index.php?action=update&id=' . (int) $product['id']
    : 'index.php?action=store';

$values = [
    'kode_produk' => $product['kode_produk'] ?? '',
    'nama_produk' => $product['nama_produk'] ?? '',
    'kategori' => $product['kategori'] ?? '',
    'harga' => $product['harga'] ?? '',
    'stok' => $product['stok'] ?? 0
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit' : 'Tambah' ?> Produk</title>
    <style>
        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 25px;
            background: white;
            border-radius: 12px;
        }
        label { display: block; margin-top: 15px; }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button, .back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 14px;
            border: 0;
            border-radius: 5px;
            color: white;
            background: #b5122b;
            text-decoration: none;
            cursor: pointer;
        }
        .back { background: #64748b; }
        .error {
            padding: 10px;
            background: #fee2e2;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1><?= $isEdit ? 'Edit' : 'Tambah' ?> Produk</h1>

    <?php if (!empty($errorMessage)): ?>
        <p class="error"><?= e($errorMessage) ?></p>
    <?php endif; ?>

    <form method="POST" action="<?= e($action) ?>">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken ?? '') ?>">

        <label for="kode_produk">Kode Produk</label>
        <input id="kode_produk" name="kode_produk" maxlength="20"
               value="<?= e($values['kode_produk']) ?>" required>

        <label for="nama_produk">Nama Produk</label>
        <input id="nama_produk" name="nama_produk" maxlength="100"
               value="<?= e($values['nama_produk']) ?>" required>

        <label for="kategori">Kategori</label>
        <input id="kategori" name="kategori" maxlength="50"
               value="<?= e($values['kategori']) ?>" required>

        <label for="harga">Harga (Rp)</label>
        <input id="harga" type="number" name="harga" min="0" step="0.01"
               value="<?= e($values['harga']) ?>" required>

        <label for="stok">Stok</label>
        <input id="stok" type="number" name="stok" min="0" step="1"
               value="<?= e($values['stok']) ?>" required>

        <button type="submit"><?= $isEdit ? 'Simpan Perubahan' : 'Tambah Produk' ?></button>
        <a class="back" href="index.php">Kembali</a>
    </form>
</div>
</body>
</html>
