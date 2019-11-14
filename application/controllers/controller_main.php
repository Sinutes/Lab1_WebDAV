<?php
/*
 * Контроллер страницы по умолчанию.
 * */
class controller_main extends Controller
{
    function __construct()
    {
        $this->view = new View();
    }

    function action_index()
    {
        $this->view->generate('main_view.php', 'template_view.php');
    }
}