<?php
namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeView extends BaseCommand
{
    protected $group = 'custom';
    protected $name = 'make:view';
    protected $description = 'Membuat file view baru di app/Views';

    public function run(array $params)
    {
        if (empty($params)) {
            CLI::error('Harap masukkan nama view, contoh: php spark make:view blog/index');
            return;
        }

        $viewName = $params[0];
        $viewPath = WRITEPATH . '../app/Views/' . $viewName . '.php';

        if (file_exists($viewPath)) {
            CLI::error("View $viewName sudah ada.");
            return;
        }

        // Buat folder jika perlu
        $dir = dirname($viewPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Isi awal view
        $template = "<!-- View: $viewName -->\n<h1>Hello from $viewName</h1>";

        file_put_contents($viewPath, $template);
        CLI::write("View berhasil dibuat: app/Views/$viewName.php", 'green');
    }
}
