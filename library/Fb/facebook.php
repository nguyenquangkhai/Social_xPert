<?php

class Fb_Facebook
{
 
    private static $fb;
 
    private static function getFB()
    {
        if(self::$fb)
        {
            return self::$fb;
        }
 
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
 
        $options = $bootstrap->getOptions();
 
        $fb = new FbSDK_Facebook(array(
            'appId' => $options['facebook']['appid'],
            'secret' => $options['facebook']['appsecret'],
            'cookie' => $options['facebook']['cookie'],
            'fileUpload' => $options['facebook']['fileupload'],
        ));
 
        self::$fb = $fb;
 
        return self::$fb;
    }
 
    public static function __callStatic ( $name, $args )
    {
        $callback = array ( self::getFB(), $name ) ;
        return call_user_func_array ( $callback , $args ) ;
    }
}

?>