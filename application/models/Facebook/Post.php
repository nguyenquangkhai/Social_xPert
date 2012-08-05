<?php

class Application_Model_Facebook_Post
{
    /**Note
    * Type of page post
        Events
        Links
        Notes
        Photos
        Milestones
        Questions
        Status Updates
        Videos
        Offers
    **/
    protected $_postId;
    protected $_message = null;
    protected $_picture = null;
    protected $_type = 0;
    protected $_createdTime;
    protected $_updatedTime;
    
    public function createPost($page_id, $type, $data){
        /**Note
          *Must be admin and have access_token
          *$data is array from facebook develop graph api
          */
        try {
            $page_info = Fb_Facebook::api($page_id."?fields=access_token");
            if(!empty($page_info['access_token'])) {
                $data['access_token'] = $page_info['access_token'];
                return $post = Fb_Facebook::api($page_id."/".$type, "POST", $data);
            }
            else {
                throw new Exception('No have access token');
            }
        } catch(FacebookApiException $e) {
            throw new Exception($e);
        }
    }

    public function getPost($post_id, $data=null){
        /**Note
          *Must be admin and have access_token
          *$data is array from facebook develop graph api
          */
        try {
            $post = Fb_Facebook::api($post_id, "GET", $data);
            return $post;
        } catch(FacebookApiException $e) {
            throw new Exception($e);
        }
    }
    
    public function getPosts($page_id, $data=null){
        /**Note
          *Must be admin and have access_token
          *$data is array from facebook develop graph api
          */
        try {
            $posts = Fb_Facebook::api($page_id."/posts", "GET", $data);
            return $posts;    
        } catch(FacebookApiException $e) {
            throw new Exception($e);
        }
    }
    
    public function getPageInfo($page_id){
        try {
            $page_info = Fb_Facebook::api($page_id."?fields=access_token");
            if(!empty($page_info['access_token'])) {
                $data['access_token'] = $page_info['access_token'];
                $posts = Fb_Facebook::api($page_id, "GET", $data);
                return $posts;
            }
            else{
                throw new Exception('No have access token');
            }           
        } catch(FacebookApiException $e) {
            throw new Exception($e);
        }
    }
    
    public function hidePost($post_id, $is_hidden=true){
        /**Note
         * Must be manage_pages and have access_token
         * $data is array from facebook develop graph api
         * $data = array(
         *      'access_token'  => string,  if you have
         *      'is_hidden'     => boolean, Whether a post is hidden
         * )  
         **/
        try {
            $data['is_hidden'] = $is_hidden;
            return $post = Fb_Facebook::api($post_id, "POST", $data);
        } catch(FacebookApiException $e) {
            throw new Exception($e);
        }
    }
}
