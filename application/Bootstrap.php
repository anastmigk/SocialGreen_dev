<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initViewHelpers()
    {
        $view = new Zend_View();
        $view->headTitle('Social Green Project')->setSeparator(' - ');
    }

}

