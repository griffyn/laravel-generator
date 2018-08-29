<?php
namespace Stormsurges\Generator\Makes;

use Stormsurges\Generator\GeneratorException;
use Illuminate\Filesystem\Filesystem;

class MakeController
{
    use MakeTrait;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function make(string $name)
    {
        $metas = $this->makeMetas($name);

        $fileName = $metas['Models'] . 'Controller';

        $path = $this->getPath($fileName, 'controller');

        if ($this->files->exists($path)) {
            throw GeneratorException::controllerAlreadyExists($fileName);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileControllerStub($metas));

        return true;

    }

    protected function compileControllerStub(array $metas)
    {
        $stub = $this->files->get(substr(__DIR__, 0, -5) . 'Stubs/Controller.stub');

        $this->buildStub($metas, $stub);

        return $stub;
    }
}
