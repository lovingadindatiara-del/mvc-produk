
<?php

class Produk
{
    private PDO $conn;
    private string $table = 'produk';

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // Mengambil semua data produk
    public function getAll(): array
    {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->conn->query($query);

        return $stmt->fetchAll();
    }

    // Mengambil satu produk berdasarkan ID
    public function findById(int $id): array|false
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    // Menambahkan produk
    public function insert(array $data): bool
    {
        $query = "INSERT INTO {$this->table}
                  (kode_produk, nama_produk, kategori, harga, stok)
                  VALUES
                  (:kode_produk, :nama_produk, :kategori, :harga, :stok)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            'kode_produk' => $data['kode_produk'],
            'nama_produk' => $data['nama_produk'],
            'kategori' => $data['kategori'],
            'harga' => $data['harga'],
            'stok' => $data['stok']
        ]);
    }

    // Memperbarui produk
    public function update(int $id, array $data): bool
    {
        $query = "UPDATE {$this->table}
                  SET kode_produk = :kode_produk,
                      nama_produk = :nama_produk,
                      kategori = :kategori,
                      harga = :harga,
                      stok = :stok
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            'id' => $id,
            'kode_produk' => $data['kode_produk'],
            'nama_produk' => $data['nama_produk'],
            'kategori' => $data['kategori'],
            'harga' => $data['harga'],
            'stok' => $data['stok']
        ]);
    }

    // Menghapus produk
    public function delete(int $id): bool
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute(['id' => $id]);
    }
}
