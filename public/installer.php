<?php

session_start();
$step = (int) ($_POST['step'] ?? 1);

$viewPath = __DIR__ . '/../resources/installer/';

$render = function (string $view, array $data = []) use ($viewPath) {
    extract($data);
    include $viewPath . $view . '.php';
};

if ($step === 1) {
    $render('form');
    exit;
}

$host = $_POST['db_host'] ?? '';
$db = $_POST['db_name'] ?? '';
$user = $_POST['db_user'] ?? '';
$pass = $_POST['db_pass'] ?? '';
$appName = $_POST['app_name'] ?? 'PaketSatis';
$adminEmail = $_POST['admin_email'] ?? '';
$adminPass = $_POST['admin_pass'] ?? '';

try {
    $pdo = new \PDO(
        "mysql:host={$host};dbname={$db};charset=utf8mb4",
        $user,
        $pass,
        [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
    );
} catch (\Throwable $e) {
    $render('form', ['error' => 'Veritabanına bağlanılamadı: ' . $e->getMessage()]);
    exit;
}

$env = [
    'app' => [
        'name' => $appName,
        'env' => 'production',
        'debug' => false,
        'url' => ($_SERVER['REQUEST_SCHEME'] ?? 'https') . '://' . $_SERVER['HTTP_HOST'],
        'locale' => 'tr',
        'fallback_locale' => 'en',
        'key' => 'base64:' . base64_encode(random_bytes(32)),
        'csrf_salt' => bin2hex(random_bytes(16)),
        'version' => '1.0.0'
    ],
    'database' => [
        'host' => $host,
        'port' => 3306,
        'database' => $db,
        'username' => $user,
        'password' => $pass,
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci'
    ],
    'mail' => [
        'driver' => 'smtp',
        'host' => 'smtp.example.com',
        'port' => 587,
        'username' => 'mailer@example.com',
        'password' => 'secret',
        'encryption' => 'tls',
        'from' => ['address' => 'no-reply@example.com', 'name' => $appName]
    ],
    'payment' => [
        'iyzico' => ['api_key' => '', 'secret_key' => '', 'base_url' => 'https://sandbox-api.iyzipay.com'],
        'paytr' => ['merchant_id' => '', 'merchant_key' => '', 'merchant_salt' => '', 'base_url' => 'https://test.paytr.com']
    ],
    'security' => [
        'rate_limit' => [
            'login' => ['max_attempts' => 5, 'decay_minutes' => 15],
            'webhook' => ['max_attempts' => 30, 'decay_minutes' => 1]
        ]
    ],
];
file_put_contents(__DIR__ . '/../config/env.php', '<?php return ' . var_export($env, true) . ';');

$sql = file_get_contents(__DIR__ . '/../database/schema.sql');
$pdo->exec($sql);
$seed = file_get_contents(__DIR__ . '/../database/seed.sql');
$pdo->exec($seed);

$hash = password_hash($adminPass, PASSWORD_BCRYPT);
$pdo->prepare("UPDATE users SET email = ?, password_hash = ? WHERE id = 1")->execute([$adminEmail, $hash]);

if (!is_dir(__DIR__ . '/../storage')) {
    mkdir(__DIR__ . '/../storage', 0775, true);
}
if (!is_dir(__DIR__ . '/../public/uploads')) {
    mkdir(__DIR__ . '/../public/uploads', 0775, true);
}

touch(__DIR__ . '/../storage/install.log');

$render('result');
