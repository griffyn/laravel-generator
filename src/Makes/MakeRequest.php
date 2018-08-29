<?php
namespace Stormsurges\Generator\Makes;

use Illuminate\Filesystem\Filesystem;
use Stormsurges\Generator\GeneratorException;

class MakeRequest
{
    use MakeTrait;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function make(string $name)
    {
        $metas = $this->makeMetas($name);

        $fileName = $metas['Model'] . 'Request';

        $path = $this->getPath($fileName, 'request');

        if ($this->files->exists($path)) {
            throw GeneratorException::requestAlreadyExists($fileName);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileRequestStub($metas));

        return true;

    }

    protected function bulidMessages($models, &$template){

        $columns = $this->getColumnListing($models);

        $columns = var_export(
            array_combine(
                array_values($columns), array_values($columns)
            )
        , true);

        $template = str_replace("{{messages}}", $columns, $template);

        return $template;
    }

    protected function compileRequestStub(array $metas)
    {
        $stub = $this->files->get(substr(__DIR__, 0, -5) . 'Stubs/Request.stub');

        $this->buildStub($metas, $stub);
        $this->bulidMessages($metas['models'], $stub);

        return $stub;
    }
}
