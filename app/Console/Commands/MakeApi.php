<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xingstation:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成Controller Model Request Transformer';

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
     * @return mixed
     */
    public function handle()
    {
        $model = $this->ask('输入模型名');
        $defaultNameSpace = [
            '0' => '\Http\Controllers\Admin\\' . $model . '\V1\Api',
            '1' => '\Http\Controllers\Admin\\' . $model . '\V1\Request',
            '2' => '\Http\Controllers\Admin\\' . $model . '\V1\Models',
            '3' => '\Http\Controllers\Admin\\' . $model . '\V1\Transformer',
            '4' => '\Http\Controllers\Admin\\' . $model . '\V1',
        ];
        $stub = [
            '0' => __DIR__ . '/stubs/controller.stub',
            '1' => __DIR__ . '/stubs/request.stub',
            '2' => __DIR__ . '/stubs/model.stub',
            '3' => __DIR__ . '/stubs/transformer.stub',
            '4' => __DIR__ . '/stubs/routes.stub'
        ];

        for ($i = 0; $i < 5; $i++) {

            $this->files = new Filesystem();
            if ($i == 0) {
                $name = $model . 'Controller';
            } else if ($i == 1) {
                $name = $model . 'Request';
            } else if ($i == 3) {
                $name = $model . 'Transformer';
            } else if ($i == 4) {
                $name = 'routes';
            } else {
                $name = $model;
            }
            $name = $this->qualifyClass($name, $defaultNameSpace[$i]);
            $path = $this->getPath($name);

            $this->makeDirectory($path);

            $this->files->put($path, $this->buildClass($name, $stub[$i]));
            $this->info($name . ' created successfully.');
        }

    }

    protected function qualifyClass($name, $defaultNameSpace)
    {
        $name = ltrim($name, '\\/');

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        $name = str_replace('/', '\\', $name);

        return $this->qualifyClass(
            trim($rootNamespace, '\\') . $defaultNameSpace . '\\' . $name, $defaultNameSpace
        );
    }

    protected function rootNamespace()
    {
        return $this->laravel->getNamespace();
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . '.php';
    }

    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    protected function buildClass($name, $stub)
    {
        $stub = $this->files->get($stub);

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyUserModel'],
            [$this->getNamespace($name), $this->rootNamespace(), config('auth.providers.users.model')],
            $stub
        );

        return $this;
    }

    protected function getNamespace($name)
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);

        return str_replace('DummyClass', $class, $stub);
    }

}
