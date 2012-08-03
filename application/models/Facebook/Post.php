<?php

class Application_Model_Facebook_Post
{
    protected $_postId;
    protected $_message = null;
    protected $_picture = 0;
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
                return $post = Fb_Facebook::api($page_id."/".$type,"POST",$data);
            }
            else {
                throw new Exception('No have access token');
            }
        } catch(FacebookApiException $e) {
            throw new Exception($e);
        }
    }

    public function getPost($post_id){
        /**Note
          *Must be admin and have access_token
          *$data is array from facebook develop graph api
          */
        try {
            $post = Fb_Facebook::api($post_id);
            return $post;
        } catch(FacebookApiException $e) {
            throw new Exception($e);
        }
    }
    
    public function getPosts($page_id){
        /**Note
          *Must be admin and have access_token
          *$data is array from facebook develop graph api
          */
        try {
            $posts = Fb_Facebook::api($page_id."/posts");
            return $posts;
        } catch(FacebookApiException $e) {
            throw new Exception($e);
        }
    }
}
