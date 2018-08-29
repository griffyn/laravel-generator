<?php
namespace Stormsurges\Generator\Makes;

use Illuminate\Filesystem\Filesystem;
use Stormsurges\Generator\GeneratorException;

class MakeResource
{
    use MakeTrait;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function make(string $name)
    {
        $metas = $this->makeMetas($name);

        $fileName = $metas['Model'] . 'Resource';

        $path = $this->getPath($fileName, 'resource');

        if ($this->files->exists($path)) {
            throw GeneratorException::resourceAlreadyExists($fileName);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileResourceStub($metas));

        return true;

    }

    protected function bulidColumns($models, &$template){

        $columns = $this->getColumnListing($models);

        $columns = var_export(
            array_combine(
                array_values($columns), array_values($columns)
            )
        , true);

        $columns = str_replace("=> '", '=> $this->', $columns);
        $columns = str_replace("',", ',', $columns);

        $template = str_replace("{{columns}}", $columns, $template);

        return $template;
    }


    protected function compileResourceStub(array $metas)
    {
        $stub = $this->files->get(substr(__DIR__, 0, -5) . 'Stubs/Resource.stub');

        $this->buildStub($metas, $stub);

        $this->bulidColumns($metas['models'], $stub);

        return $stub;
    }
}
