<?php
// public/index.php - front controller
require __DIR__ . '/../db.php';

// Autoload composer packages (blade etc.)
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    echo "Composer dependencies are missing. Run `composer require illuminate/view illuminate/filesystem illuminate/events` from project root and refresh.";
    exit;
}
require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Filesystem\Filesystem;
use Illuminate\Events\Dispatcher;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;

$files = new Filesystem;
$events = new Dispatcher;
$resolver = new EngineResolver;

// Blade compiler / engine
$bladeCompiler = new BladeCompiler($files, __DIR__ . '/../cache/views');
$resolver->register('blade', function () use ($bladeCompiler, $files) {
    return new CompilerEngine($bladeCompiler, $files);
});
$resolver->register('php', function () use ($files) {
    return new \Illuminate\View\Engines\PhpEngine;
});

$finder = new FileViewFinder($files, [__DIR__ . '/../app/views']);
$blade = new Factory($resolver, $finder, $events);

// Autoload app files (simple)
require __DIR__ . '/../app/models/Student.php';
require __DIR__ . '/../app/controllers/StudentController.php';

// Instantiate Model + Controller
$studentModel = new \App\Models\Student($conn);
$controller = new \App\Controllers\StudentController($studentModel, $blade);

// Simple routing via ?page=...
$page = $_GET['page'] ?? 'students';

switch ($page) {
    case 'students':
        $controller->index();
        break;
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'edit':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $controller->edit($id);
        break;
    case 'update':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $controller->update($id);
        break;
    case 'delete':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $controller->delete($id);
        break;
    default:
        $controller->index();
        break;
}
