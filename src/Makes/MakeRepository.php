<?php
namespace Stormsurges\Generator\Makes;

use Stormsurges\Generator\GeneratorException;
use Illuminate\Filesystem\Filesystem;

class MakeRepository
{
    use MakeTrait;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function make(string $name)
    {
        $metas = $this->makeMetas($name);

        $fileName = $metas['Model'].'Repository';

        $path = $this->getPath($fileName, 'repository');
        
        if( $this->files->exists($path) ){
            throw GeneratorException::repositoryAlreadyExists($fileName);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileRepositoryStub($metas));

        return true;
    }

    protected function compileRepositoryStub(array $metas)
    {
        $stub = $this->files->get(substr(__DIR__,0, -5) . 'Stubs/Repository.stub');
        
        $this->buildStub($metas, $stub);

        return $stub;
    }
}