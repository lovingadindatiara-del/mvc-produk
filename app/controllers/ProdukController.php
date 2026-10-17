
<?php

class ProdukController
{
    private Produk $model;

    public function __construct(Produk $model)
    {
        $this->model = $model;
    }

    public function index(): array
    {
        return $this->model->getAll();
    }

    public function create(array $data): array
    {
        $errors = $this->validate($data);

        if (!empty($errors)) {
            return [
                'success' => false,
                'message' => implode(' ', $errors)
            ];
        }

        try {
            $this->model->insert($data);

            return [
                'success' => true,
                'message' => 'Produk berhasil ditambahkan.'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Gagal menambahkan produk. Periksa kode produk.'
            ];
        }
    }

    public function show(int $id): array|false
    {
        return $this->model->findById($id);
    }

    public function edit(int $id, array $data): array
    {
        $errors = $this->validate($data);

        if (!empty($errors)) {
            return [
                'success' => false,
                'message' => implode(' ', $errors)
            ];
        }

        try {
            $product = $this->model->findById($id);

            if (!$product) {
                return [
                    'success' => false,
                    'message' => 'Produk tidak ditemukan.'
                ];
            }

            $this->model->update($id, $data);

            return [
                'success' => true,
                'message' => 'Produk berhasil diperbarui.'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Gagal memperbarui produk. Periksa kode produk.'
            ];
        }
    }

    public function destroy(int $id): array
    {
        $product = $this->model->findById($id);

        if (!$product) {
            return [
                'success' => false,
                'message' => 'Produk tidak ditemukan.'
            ];
        }

        $this->model->delete($id);

        return [
            'success' => true,
            'message' => 'Produk berhasil dihapus.'
        ];
    }

    private function validate(array $data): array
    {
        $errors = [];

        foreach (
            ['kode_produk', 'nama_produk', 'kategori', 'harga', 'stok']
            as $field
        ) {
            if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
                $errors[] = "Kolom {$field} wajib diisi.";
            }
        }

        if (
            isset($data['harga']) &&
            trim((string) $data['harga']) !== '' &&
            (!is_numeric($data['harga']) || (float) $data['harga'] < 0)
        ) {
            $errors[] = 'Harga harus berupa angka dan tidak boleh negatif.';
        }

        if (
            isset($data['stok']) &&
            trim((string) $data['stok']) !== '' &&
            (!filter_var($data['stok'], FILTER_VALIDATE_INT) ||
             (int) $data['stok'] < 0)
        ) {
            $errors[] = 'Stok harus berupa bilangan bulat nol atau lebih.';
        }

        return $errors;
    }
}
