<?php
namespace Stormsurges\Generator\Makes;

use Stormsurges\Generator\GeneratorException;
use Illuminate\Filesystem\Filesystem;

class MakePolicy
{
    use MakeTrait;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function make(string $name)
    {
        $metas = $this->makeMetas($name);

        $fileName = $metas['Model'].'Policy';

        $path = $this->getPath($fileName, 'policy');
        
        if( $this->files->exists($path) ){
            throw GeneratorException::policyAlreadyExists($fileName);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compilePolicyStub($metas));

        return true;
    }

    protected function compilePolicyStub(array $metas)
    {
        $stub = $this->files->get(substr(__DIR__,0, -5) . 'Stubs/Policy.stub');
        
        $this->buildStub($metas, $stub);

        return $stub;
    }
}