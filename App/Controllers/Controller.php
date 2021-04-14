<?php

namespace App\Controllers;

use App\Lib\Sessao;

abstract class Controller
{
    protected $app;
    private $viewVar;

    public function __construct($app)
    {
        $this->setViewParam('nameController', $app->getControllerName());
        $this->setViewParam('nameAction', $app->getAction());
    }

    
    public function setViewParam($varName, $varValue)
    {
        if(!empty($varName) && !empty($varValue))
        {
            $this->viewVar[$varName] = $varValue;
        }
    }
    
    public function render($view)
    {
        $viewVar = $this->getViewVar();
        $Sessao  = Sessao::class;

        require_once PATH . '/App/Views/layout/header.php';
        require_once PATH . '/App/Views/layout/menu.php';
        require_once PATH . '/App/Views/' . $view . '.php';
        require_once PATH . '/App/Views/layout/footer.php';

    }

    public function redirect($view)
    {
        header('Location: ' . APP_HOST . $view);
        exit;
    }

     /**
     * Get the value of viewVar
     */
    public function getViewVar()
    {
        return $this->viewVar;
    }
}
