<?php
namespace Stormsurges\Generator\Makes;

use Stormsurges\Generator\GeneratorException;
use Illuminate\Filesystem\Filesystem;

class MakeService
{
    use MakeTrait;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function make(string $name)
    {
        $metas = $this->makeMetas($name);

        $fileName = $metas['Models'].'Service';

        $path = $this->getPath($fileName, 'service');
        
        if( $this->files->exists($path) ){
            throw GeneratorException::serviceAlreadyExists($fileName);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileServiceStub($metas));

        return true;
    }

    protected function compileServiceStub(array $metas)
    {
        $stub = $this->files->get(substr(__DIR__,0, -5) . 'Stubs/Service.stub');
        
        $this->buildStub($metas, $stub);

        return $stub;
    }
}