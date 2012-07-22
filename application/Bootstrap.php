<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctype(){
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');
    }
    
    protected function _initDbRegistry(){
        $this->bootstrap('multidb');
        $multidb = $this->getPluginResource('multidb');
        Zend_Registry::set('default', $multidb->getDb('web'));
        Zend_Registry::set('facebook', $multidb->getDb('facebook'));
        Zend_Registry::set('log', $multidb->getDb('log'));
    }
}

