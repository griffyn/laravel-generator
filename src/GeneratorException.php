<?php
namespace Stormsurges\Generator;

use Exception;

class GeneratorException extends Exception
{
    protected $message = '';

    public static function controllerAlreadyExists($name)
    {
        return new static('控制器 `' . $name . '`已经存在');
    }

    public static function serviceAlreadyExists($name)
    {
        return new static('服务 `' . $name . '`已经存在');
    }

    public static function modelAlreadyExists($name)
    {
        return new static('模型 `' . $name . '`已经存在');
    }

    public static function requestAlreadyExists($name)
    {
        return new static('表单验证 `' . $name . '`已经存在');
    }

    public static function policyAlreadyExists($name)
    {
        return new static('策略 `' . $name . '`已经存在');
    }

    public static function observerAlreadyExists($name)
    {
        return new static('观察者 `' . $name . '`已经存在');
    }

    public static function resourceAlreadyExists($name)
    {
        return new static('资源 `' . $name . '`已经存在');
    }

    public static function resourceAlreadyExists($name)
    {
        return new static('资源 `' . $name . '`已经存在');
    }

    public static function collectionsAlreadyExists($name)
    {
        return new static('资源集合 `' . $name . '`已经存在');
    }

    public static function repositoryAlreadyExists($name)
    {
        return new static('仓库 `' . $name . '`已经存在');
    }
}
