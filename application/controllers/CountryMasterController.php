<?php

class CountryMasterController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $countryManager = new Application_Model_DbManager_CountryMasterManager();
        
        $country = $countryManager->findById(1);
        print_r($country->country_name);//getCountryName());
        $this->view->country = $country;
    }


}

