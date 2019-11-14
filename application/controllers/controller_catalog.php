<?php

/*
 * Контроллер сущности "Каталог".
 * */
class controller_catalog extends Controller
{
    function __construct()
    {
        //var_dump($_POST);
        $path = '/';
        $newDirectoryName = '';
        $newFileName = '';
        $pathToDelete = '';
        $previousPath = '';

        if (!empty($_POST)) {
            $directoryList = array_keys($_POST);

            $previousDirectory = $directoryList[0];
            $newDirectory = $directoryList[1];

            $path = '';
            $path .= $previousDirectory;
            $path .= $newDirectory.'/';

            $newDirectoryName = $_POST['createDirectory'];
            $newFileName = $_POST['createFile'];

            if (!empty($newDirectoryName) || !empty($newFileName)) {
                $path = $directoryList[0];
            }

            if (stripos($newDirectory, 'DELETE')) {
                $pathToDelete = str_replace('DELETE/', '', $path);
                $previousPath = $previousDirectory;
            }
        }

        $this->model = new model_catalog($path);

        if (!empty($newDirectoryName)) {
            $this->action_create_directory($newDirectoryName, $this->model);
        }

        if (!empty($newFileName)) {
            $this->action_create_file($newFileName, $this->model);
        }

        if (!empty($pathToDelete)) {
            $this->model->myPath = $pathToDelete;
            $this->action_delete_directory($pathToDelete, $this->model);
            $this->model->myPath =$previousPath;
        }

        $this->view = new View();
    }

    function action_create_directory($newDirectoryName, model_catalog $object)
    {
        $object->createDirectory($newDirectoryName);
    }

    function action_create_file($newFileName, model_catalog $object)
    {
        $object->createFile($newFileName, ' ');
    }

    function action_delete_directory($pathToDelete, model_catalog $object){
        $object->delete_directory($pathToDelete);
    }

    function action_index()
    {
        $this->view->generate('catalog_view.php', 'template_view.php', $this->model);
    }
}