<?php

namespace Hlev\JetstrapMinimal\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class JetstrapMinimalCommand extends Command {
	protected $signature = 'jetstrap:swap';

	public $description = 'Install the Jetstrap Minimal components and resources';

	public function handle(): int {
		$this->install();

		return self::SUCCESS;
	}

	protected function install(): void {
		$fs = new Filesystem;

		// update package.json
		$this->updateNodePackages(function ($packages) {
			// Remove TrailwindCSS
			unset($packages['tailwindcss']);
			unset($packages['@tailwindcss/forms']);
			unset($packages['@tailwindcss/typography']);

			// Add Bootstrap
			return [
					'@popperjs/core' => '^2.11.8',
					'bootstrap' => '^5.3.3',
					'bootstrap-icons' => '^1.11.3',
					'sass' => '^1.71.1',
				] + $packages;
		});

		// remove tailwind.config.js
		if ($fs->exists(base_path('tailwind.config.js'))) {
			$fs->delete(base_path('tailwind.config.js'));
		}
		// copy postcss.config.js and vite.config.js from stub/
		$fs->copy(__DIR__ . '/../../stubs/postcss.config.js', base_path('postcss.config.js'));
		$fs->copy(__DIR__ . '/../../stubs/vite.config.js', base_path('vite.config.js'));

		// remove resources/css/
		$fs->deleteDirectory(resource_path('css'));

		// copy resources/sass/
		$fs->ensureDirectoryExists(resource_path('sass'));
		$fs->copyDirectory(__DIR__ . '/../../stubs/resources/sass', resource_path('sass'));

		// copy resources/js/
		$fs->ensureDirectoryExists(resource_path('js'));
		$fs->copyDirectory(__DIR__ . '/../../stubs/resources/js', resource_path('js'));
		// remove Laravel welcome page
/*		if ($fs->exists(resource_path('views/welcome.blade.php'))) {
			$fs->delete(resource_path('views/welcome.blade.php'));
		}*/

		//modify '/' route
		if ($fs->exists(base_path('routes/web.php'))) {
			$fs->replaceInFile("return view('welcome')", "return to_route('dashboard')", base_path('routes/web.php') );
		}

		// copy views
		$fs->deleteDirectory(resource_path('views'));
		$fs->ensureDirectoryExists(resource_path('views'));
		$fs->copyDirectory(__DIR__ . '/../../stubs/resources/views', resource_path('views'));

		$this->line('');
		$this->info('Bootstrap 5.3 scaffolding for Livewire installed successfully.');
		$this->info('Don\'t forget to `npm update`!');
	}

	protected function updateNodePackages(callable $callback, $dev = true): void {
		if (!file_exists(base_path('package.json'))) {
			return;
		}

		$configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
	}
}