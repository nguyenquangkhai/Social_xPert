<?php

class CountryMasterController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $countryMapper = new Application_Model_DbMapper_CountryMasterMapper();
        
        $country = $countryMapper->findById(1);
        print_r($country->country_name);//getCountryName());
        $this->view->country = $country;
    }


}

