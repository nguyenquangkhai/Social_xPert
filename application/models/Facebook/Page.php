<?php

class Application_Model_Facebook_Page
{
    protected $_pageId;
    protected $_name = null;
    protected $_link = null;
    protected $_category = null;
    protected $_accessToken = null;

    public function getPages($user_id, $data=null){
        /**Note
         * Must be manage_pages and have access_token
         * $data is array from facebook develop graph api
         * $data = array(
         *      'access_token'  => string,  if you have
         * )  
         **/
        try {
            return $user_account = Fb_Facebook::api($user_id."/accounts", "GET", $data);
        } catch(FacebookApiException $e) {
            throw new Exception($e);
        }
    }
    
    public function getPageInfo($page_id, $data=null){
        /**Note
         * Must be manage_pages and have access_token
         * $data is array from facebook develop graph api
         * $data = array(
         *      'access_token'  => string,  if you have
         * )  
         **/
        try {
            return $page = Fb_Facebook::api($page_id."/home", "GET", $data);
        } catch(FacebookApiException $e) {
            throw new Exception($e);
        }
    }
        
    public function setPageAbout($page_id, $data){
        /**Note
         * Must be manage_pages and have access_token
         * $data is array from facebook develop graph api
         * $data = array(
         *      'access_token'  => string,  if you have
         *      'about'         => string,  Text for the about section of a page
         *      'description'   => string,  The description of a page
         *      'general_info'  => string,  The general information for a page
         *      'website'       => string,  The website URL for a page
         *      'phone'         => string   The Phone number for a page
         * )  
         **/
        try {
            return $post = Fb_Facebook::api($page_id, "POST", $data);
        } catch(FacebookApiException $e) {
            throw new Exception($e);
        }
    }

    public function setPageCoverPhoto($page_id, $data){
        /**Note
         * Must be manage_pages and have access_token
         * $data is array from facebook develop graph api
         * $data = array(
         *      'access_token'  => string,  if you have
         *      'cover'         => integer, The ID of the photo
         *      'offset_y'      => integer, The percentage offset from top (0-100). The default value is 50
         *      'no_feed_story' => boolean, The flag indicating whether or not to create a story. The default value is false
         * )  
         **/
        try {
            return $post = Fb_Facebook::api($page_id, "POST", $data);
        } catch(FacebookApiException $e) {
            throw new Exception($e);
        }
    }
    
    public function setPageSettings($page_id, $data){
        /**Note
         * Must be manage_pages and have access_token
         * $data is array from facebook develop graph api
         * $data = array(
         *      'access_token'  => string,  if you have
         *      'setting'       => string,  Which single setting to update: USERS_CAN_POST, USERS_CAN_POST_PHOTOS, USERS_CAN_TAG_PHOTOS, USERS_CAN_POST_VIDEOS
         *      'value'         => boolean, true or false
         * )  
         **/
        try {
            return $post = Fb_Facebook::api($page_id, "POST", $data);
        } catch(FacebookApiException $e) {
            throw new Exception($e);
        }
    } 
}
