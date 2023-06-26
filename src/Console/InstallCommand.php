<?php

namespace Appycodes\Appydash\Console;

use RuntimeException;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appydash:install
                            {--composer=global : Absolute path to the Composer binary which should be used to install packages}
                            {--php_version=php : Php version command, like `sail` or `./vendor/bin/sail` or `docker-compose up...`}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install one of the Appycodes Appydash Dashboard';

    /**
     * The artisan command to run. Default is php.
     *
     * @var string
     */
    protected string $php_version;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->php_version = $this->option('php_version');
        
        // Install breeze
        $this->requireComposerPackages('laravel/breeze:^1.4');
        shell_exec("{$this->php_version} artisan breeze:install blade");

        $this->components->info('Appydash: Breeze Install Done');

        copy(__DIR__ . '/../../resources/stubs/routes.php', base_path('routes/web.php'));

        copy(__DIR__ . '/../../resources/stubs/controllers/UserController.php', app_path('Http/Controllers/UserController.php'));
        copy(__DIR__ . '/../../resources/stubs/controllers/DashboardController.php', app_path('Http/Controllers/DashboardController.php'));

        (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/stubs/requests', app_path('Http/Requests/'));
        $this->components->info('Appydash:Controller Moved');
        return $this->replaceAppydashAssets();
    }

    protected function replaceAppydashAssets()
    {

        $this->components->info('Appydash: Moving Assets and Views');
        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/components'));
        (new Filesystem)->ensureDirectoryExists(public_path('js'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/stubs/appydash/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/stubs/appydash/views/layouts', resource_path('views/layouts'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/stubs/appydash/views/components', resource_path('views/components'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/stubs/appydash/views/profile', resource_path('views/profile'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/stubs/appydash/views/users', resource_path('views/users'));

        copy(__DIR__ . '/../../resources/stubs/appydash/views/home.blade.php', resource_path('views/home.blade.php'));
        copy(__DIR__ . '/../../resources/stubs/appydash/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));
        copy(__DIR__ . '/../../resources/stubs/appydash/views/profile/edit.blade.php', resource_path('views/profile/edit.blade.php'));

        // Assets
        copy(__DIR__ . '/../../resources/stubs/appydash/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__ . '/../../resources/stubs/appydash/css/app.css', resource_path('css/app.css'));
        copy(__DIR__ . '/../../resources/stubs/appydash/js/app.js', resource_path('js/app.js'));
   
        // Images
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/stubs/appydash/images', resource_path('images'));

        
        $this->components->info('Adding Flowbite Package');
        $this->updateNodePackages(function ($packages) {
            return [
                'flowbite' => '^1.6.6'
            ] + $packages;
        });
        $this->runCommands(['npm install', 'npm run build']);
        $this->components->info('Appycodes Admin panel installed');
    }


    /**
     * Intall Node Packages
     */
    

    /**
     * Installs the given Composer Packages into the application.
     * Taken from https://github.com/laravel/breeze/blob/1.x/src/Console/InstallCommand.php
     *
     * @param mixed $packages
     * @return void
     */
    protected function requireComposerPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            is_array($packages) ? $packages : func_get_args()
        );

        (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    /**
     * Update the "package.json" file.
     * Taken from https://github.com/laravel/breeze/blob/1.x/src/Console/InstallCommand.php
     *
     * @param callable $callback
     * @param bool $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
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
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    /**
     * Run the given commands.
     * Taken from https://github.com/laravel/breeze/blob/1.x/src/Console/InstallCommand.php
     *
     * @param  array  $commands
     * @return void
     */
    protected function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
    }
}
