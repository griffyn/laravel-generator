<?php
namespace Stormsurges\Generator\Makes;

use Stormsurges\Generator\GeneratorException;
use Illuminate\Filesystem\Filesystem;

class MakeRoute
{
    use MakeTrait;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function make(string $name)
    {
        $metas = $this->makeMetas($name);

        $path = $this->getPath($name, 'route');

        $stub = $this->compileRouteStub($metas);

        if (strpos($this->files->get($path), $stub) === false) {
            $this->files->append($path, $this->compileRouteStub($metas));
        }

        return true;
    }

    protected function compileRouteStub(array $metas)
    {
        $stub = $this->files->get(substr(__DIR__,0, -5) . 'Stubs/Route.stub');
        
        $this->buildStub($metas, $stub);

        return $stub;
    }
}