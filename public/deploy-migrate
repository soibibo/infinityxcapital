// public/deploy-migrate.php — DELETE after each use, or keep behind auth
<?php
if ($_GET['token'] !== 'fghfgskflsfosufusuf') {
    http_response_code(403);
    die('Forbidden');
}
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->call('migrate', ['--force' => true]);
echo "Migrated: " . $kernel->output();

// Here is the code to run it
// https://yourdomain.com/deploy-migrate.php?token=your-long-random-secret-here