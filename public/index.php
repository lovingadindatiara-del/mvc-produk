
<?php

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/Produk.php';
require_once __DIR__ . '/../app/controllers/ProdukController.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];
$message = $_SESSION['message'] ?? '';
$errorMessage = $_SESSION['form_error'] ?? '';
unset($_SESSION['message'], $_SESSION['form_error']);

try {
    $database = new Database();
    $db = $database->connect();

    $model = new Produk($db);
    $controller = new ProdukController($model);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Koneksi database gagal. Periksa konfigurasi database.');
}

$action = $_GET['action'] ?? 'index';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

function redirectTo(string $url = 'index.php'): never
{
    header('Location: ' . $url);
    exit;
}

function verifyCsrfToken(): void
{
    $token = $_POST['csrf_token'] ?? '';

    if (
        !is_string($token) ||
        !hash_equals($_SESSION['csrf_token'], $token)
    ) {
        http_response_code(403);
        exit('Permintaan tidak valid. Silakan muat ulang halaman.');
    }
}

function validProductId($id): bool
{
    return is_int($id) && $id > 0;
}

switch ($action) {
    case 'index':
        $products = $controller->index();

        require __DIR__ . '/../app/views/produk/index.php';
        break;

    case 'create':
        $product = null;

        require __DIR__ . '/../app/views/produk/form.php';
        break;

    case 'store':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Metode tidak diizinkan.');
        }

        verifyCsrfToken();

        $result = $controller->create($_POST);
        $_SESSION['message'] = $result['message'];

        if (!$result['success']) {
            $_SESSION['form_error'] = $result['message'];
            redirectTo('index.php?action=create');
        }

        redirectTo();

    case 'edit':
        if (!validProductId($id)) {
            http_response_code(400);
            exit('ID produk tidak valid.');
        }

        $product = $controller->show($id);

        if (!$product) {
            http_response_code(404);
            exit('Produk tidak ditemukan.');
        }

        $errorMessage = '';

        require __DIR__ . '/../app/views/produk/form.php';
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Metode tidak diizinkan.');
        }

        verifyCsrfToken();

        if (!validProductId($id)) {
            http_response_code(400);
            exit('ID produk tidak valid.');
        }

        $result = $controller->edit($id, $_POST);
        $_SESSION['message'] = $result['message'];

        if (!$result['success']) {
            redirectTo('index.php?action=edit&id=' . $id);
        }

        redirectTo();

    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Metode tidak diizinkan.');
        }

        verifyCsrfToken();

        $deleteId = filter_var(
            $_POST['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (!validProductId($deleteId)) {
            http_response_code(400);
            exit('ID produk tidak valid.');
        }

        $result = $controller->destroy($deleteId);
        $_SESSION['message'] = $result['message'];

        redirectTo();

    default:
        http_response_code(404);
        echo 'Halaman tidak ditemukan.';
        break;
}
