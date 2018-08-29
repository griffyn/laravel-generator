<?php
namespace Stormsurges\Generator\Makes;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Schema;

trait MakeTrait
{

    protected $files;

    protected function getStubPath()
    {
        return substr(__DIR__, 0, -5) . 'Stubs' . DIRECTORY_SEPARATOR;
    }

    public function makeMetas(string $name)
    {
        $names = str_plural($name);

        $metas = [
            'model'  => lcfirst(camel_case($name)),
            'models' => lcfirst(camel_case($names)),
            'Model' => ucfirst(camel_case($name)),
            'Models' => ucfirst(camel_case($names)),
        ];

        return $metas;
    }

    protected function getColumnListing($models){

        return Schema::getColumnListing($models);

    }

    protected function buildStub(array $metas, &$template)
    {
        foreach ($metas as $k => $v) {
            $template = str_replace("{{" . $k . "}}", $v, $template);
        }
        return $template;
    }

    protected function getPath($fileName, $path = 'controller')
    {
        if ($path == "controller") {
            return app_path('Http/Controllers/' . $fileName . '.php');
        } elseif ($path == "request") {
            return app_path('Http/Requests/' . $fileName . '.php');
        } elseif ($path == "resource") {
            return app_path('Http/Resources/' . $fileName . '.php');
        } elseif ($path == "collection") {
            return app_path('Http/Resources/collections/' . $fileName . '.php');
        } elseif ($path == "service") {
            return app_path('Services/' . $fileName . '.php');
        } elseif ($path == "repository") {
            return app_path('Repositories/' . $fileName . '.php');
        } elseif ($path == "observer") {
            return app_path('Observers/' . $fileName . '.php');
        } elseif ($path == "policy") {
            return app_path('Policies/' . $fileName . '.php');
        } elseif ($path == "model") {
            return app_path('Models/' . $fileName . '.php');
        }elseif($path == "route"){
            return base_path('routes/api.php');
        }
    }

    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    protected function compileStub($filename)
    {
        $stub = $this->files->get(substr(__DIR__, 0, -5) . 'Stubs/' . $filename . '.stub');
        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);
        return $stub;
    }

    protected function getAppNamespace()
    {
        return Container::getInstance()->getNamespace();
    }
}
