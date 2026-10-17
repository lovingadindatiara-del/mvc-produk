
<?php
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #263238;
        }
        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px #00000010;
        }
        h1 { margin-top: 0; }
        .btn {
            display: inline-block;
            padding: 9px 13px;
            color: white;
            background: #b5122b;
            text-decoration: none;
            border: 0;
            border-radius: 5px;
            cursor: pointer;
        }
        .table-wrap { overflow-x: auto; margin-top: 20px; }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }
        th { background: #f8e9ec; }
        .actions { display: flex; gap: 6px; }
        .edit { background: #2563eb; }
        .delete { background: #b5122b; }
        .message {
            padding: 12px;
            background: #e8f5e9;
            border-radius: 5px;
            margin: 15px 0;
        }
        form { display: inline; }
        @media (max-width: 600px) {
            body { padding: 12px; }
            .container { padding: 15px; }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Data Produk</h1>
    <p>Kelola data produk dengan mudah melalui aplikasi CRUD.</p>

    <?php if (!empty($message)): ?>
        <div class="message"><?= e($message) ?></div>
    <?php endif; ?>

    <a class="btn" href="index.php?action=create">+ Tambah Produk</a>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="7">Belum ada data produk.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $i => $product): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= e($product['kode_produk']) ?></td>
                            <td><?= e($product['nama_produk']) ?></td>
                            <td><?= e($product['kategori']) ?></td>
                            <td>Rp <?= number_format((float) $product['harga'], 0, ',', '.') ?></td>
                            <td><?= e($product['stok']) ?></td>
                            <td>
                                <div class="actions">
                                    <a class="btn edit"
                                       href="index.php?action=edit&id=<?= (int) $product['id'] ?>">
                                        Edit
                                    </a>
                                    <form method="POST"
                                          action="index.php?action=delete"
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        <input type="hidden" name="id"
                                               value="<?= (int) $product['id'] ?>">
                                        <input type="hidden" name="csrf_token"
                                               value="<?= e($csrfToken ?? '') ?>">
                                        <button class="btn delete" type="submit">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
