<?php

/*
 * Модель сущности "Каталог".
 * */
class model_catalog extends Model{

    public $myPath;

    function __construct($myPath)
    {
        $this->myPath = $myPath;
    }

    function getName()
    {
        return basename($this->myPath);
    }

    function getCatalog()
    {
        return scandir($this->myPath);
    }

    function createDirectory($name)
    {
        mkdir($this->myPath . '/' . $name);
    }

    function createFile($name, $data)
    {
        file_put_contents($this->myPath . basename($name),$data);
    }

    function delete_directory()
    {
        rmdir($this->myPath);
    }

    function put($data)
    {
        file_put_contents($this->myPath,$data);
    }
}
