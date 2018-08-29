<?php
namespace Stormsurges\Generator\Makes;

use Stormsurges\Generator\GeneratorException;
use Illuminate\Filesystem\Filesystem;

class MakeModel
{
    use MakeTrait;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function make(string $name, $fillable = '')
    {
        $metas = $this->makeMetas($name);

        $path = $this->getPath($metas['Model'], 'model');

        $this->makeBaseModelIfNotExists();

        if( $this->files->exists($path) ){
            throw GeneratorException::modelAlreadyExists($metas['Model']);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileModelStub($metas));

        return true;
    }

    protected function makeBaseModelIfNotExists()
    {
        $path = $this->getPath("Model", 'model');

        if (!$this->files->exists($path))
        {
            $this->makeDirectory($path);
            $this->files->put($path, $this->compileBaseModelStub());
        }

        return true;
    }

    protected function compileBaseModelStub()
    {
        $stub = $this->files->get(substr(__DIR__,0, -5) . 'Stubs/BaseModel.stub');

        return $stub;
    }

    protected function compileModelStub(array $metas)
    {
        $stub = $this->files->get(substr(__DIR__,0, -5) . 'Stubs/Model.stub');
        
        $this->buildStub($metas, $stub);

        return $stub;
    }
}