<?php

class FacebookController extends Zend_Controller_Action
{
    private $_controller = "facebook";
    
    public function init(){
        /**Note
          *Initialize action controller here
          */
    }

    public function indexAction(){
        /**Note
          *...
          */
        $obj = new Application_Model_Facebook_Page();
     //   $post_id = "449021921787077_450553698300566";
     //   $posts = $obj->getCheckins("421753514532658");
        $posts = $obj->getAccessToken("421753514532658");
        $this->view->data = $posts;
        
    }

    public function loginAction(){
        /**Note
          *...
          */
        $loginUrl = Fb_Facebook::getLoginUrl(array(
            'scope' => 'publish_stream,publish_actions,manage_pages',
            'redirect_uri' => 'http://localhost/Social_Xpert/index.php/'.$this->_controller
        )); 
        $this->_redirect($loginUrl);
    }
    
    public function logoutAction(){
        /**Note
          *...
          */
        $logoutUrl = Fb_Facebook::getLogoutUrl(array(
	       'next' => 'http://localhost/Social_Xpert/index.php/'.$this->_controller
        ));
        $this->_redirect($logoutUrl);
    }
    
    private function _getPages($user){
        /**Note
          *Raw
          */
        $user_account = Fb_Facebook::api($user."/accounts");
        return $user_account;
    }
    
    private function _postPage($page, $type, $data){
        /**Note
          *Must be admin and have access_token
          *$data is array from facebook develop graph api
          */
        $page_info = Fb_Facebook::api($page."?fields=access_token");
        if( !empty($page_info['access_token']) ) {
        	$data['access_token'] = $page_info['access_token'];
        	return $post = Fb_Facebook::api($page."/".$type,"POST",$data);
        }
        else
            return null;      
    }
    
    public function feedAction(){
        /**Note
          *...
          */        
        try {
            $page = $this->_request->getParam('post_user_id');
            $type = "feed";            
            $data = array(
                'message' => $this->_request->getParam('post_new'),//string
//                'link' => 'http://youtu.be/fWNaR-rxAic',//string URL
//                'picture' => 'http://www.imagemagick.org/Magick++/thumbnail-anatomy-framed.jpg',//string //Post thumbnail image (can only be used if link is specified) 
//                'name' => 'name',//string //Post name (can only be used if link is specified) 
//                'caption' => 'cap',//string //Post caption (can only be used if link is specified) 
//                'description' => 'des',//string //Post description (can only be used if link is specified) 
//                'action' => array(
//                    'name' => 'name',
//                    'link' => 'http://youtu.be/fWNaR-rxAic'
//                ),//array of objects containing name and link 
//                'targeting' => json_encode(array('countries' => ['US','GB']),//JSON object containing countries, cities, regions or locales// Example: {'countries':['US','GB']} 
//                'published' => true,//boolean //Whether a post is published. Default is published. This field is `not` supported when actions parameter is specified. 
//                'scheduled_publish_time' => '',//UNIX timestamp //Time when the page post should go live, this should be between 10 mins and 6 months from the time of publishing the post.
            );
            $page_info = Fb_Facebook::api($page_id."?fields=access_token");
            if( !empty($page_info['access_token']) ) {
                $data['access_token'] = $page_info['access_token'];
                $post = new Application_Model_Facebook_Post();
                $feed_post = $post->createPost($page_id, $type, $data);

                if($feed_post){
                    echo $feed_post['id'];
                    exit();
                }
                else{
                    echo 'fail';
                    exit();
                }
            }
            else{
                echo "empty access token";
            }
        } catch (FacebookApiException $e) {
            echo $e;
            exit();
        }
    }
      
    public function photoAction(){
        /**Note
          *30/7 Raw function
          */        
        try {
            $page_id = $this->_request->getParam('page_id');
            $type = "photos";            

            $valid_photos = array('jpeg', 'jpg', 'png', 'gif');
            $upload = new Zend_File_Transfer_Adapter_Http;

            $upload->addValidator('Extension', false, $valid_photos);
            if($upload->isValid()){
                $files = $upload->getFileInfo();
                           
                $data = array(
                    'message' => $this->_request->getParam('message'),
                    'source' => '@'.realpath($files['pic']['tmp_name']),
//                    'targeting' => json_encode(array('countries' => ['US','GB']),//JSON object containing countries, cities, regions or locales// Example: {'countries':['US','GB']} 
//                    'published' => true,//boolean //Whether a post is published. Default is published. This field is `not` supported when actions parameter is specified. 
//                    'scheduled_publish_time' => '',//UNIX timestamp //Time when the page post should go live, this should be between 10 mins and 6 months from the time of publishing the post.                    
//                    'aid' => '123'//$album_id,
//                    'no_story' => 1
                );
                
                $page_info = Fb_Facebook::api($page_id."?fields=access_token");
                if( !empty($page_info['access_token']) ) {
                    $data['access_token'] = $page_info['access_token'];
                    $post = new Application_Model_Facebook_Post();
                    $photo_post = $post->createPost($page_id, $type, $data);

                    if($photo_post){
                        echo $photo_post['id'];
                        exit();
                    }
                    else{
                        echo 'fail';
                        exit();
                    }
                }
                else{
                    echo "empty access token";
                }
            }
            else{
                echo "invalid image";
            }
        } catch (FacebookApiException $e) {
            echo $e;
            exit();
        }
//          $upload->setDestination(APPLICATION_PATH.'\images')
//          $upload->addValidator('Size', false, array('min' => '1kB', 'max' => '100MB'));
//            if($upload->receive())
//                print_r ($file);
//            else 
//                echo 'fail';
    }
    
    public function videoAction(){
        /**Note
          *why invalid format???
          */  
        try {
            $page = $this->_request->getParam('page_id');
            $type = "videos";            

            $valid_videos = array('flv', 'mp4', '3gp', 'avi');
            $upload = new Zend_File_Transfer_Adapter_Http;

            $upload->addValidator('Extension', false, $valid_videos);
            if($upload->isValid()){
                $files = $upload->getFileInfo();
                           
                $data = array(
                    'title' => $this->_request->getParam('title'),
                    'description' => $this->_request->getParam('description'),
                    'source' => '@'.realpath($files['vid']['tmp_name']),
//                    'published' => true,//boolean //Whether a post is published. Default is published. This field is `not` supported when actions parameter is specified. 
//                    'scheduled_publish_time' => '',//UNIX timestamp //Time when the page post should go live, this should be between 10 mins and 6 months from the time of publishing the post.                    
                );
                
                $video_post = $this->_postPage($page, $type, $data);
                if($video_post){
                    echo $video_post['post_id'];
                    exit();
                }
            }
            else{
                echo 'fail';
                //$this->_redirect('')
            }
        } catch (FacebookApiException $e) {
            echo $e;
            exit();
        }          
    }
    
    public function eventAction(){
        /**Note
          *unix time???
          */
        try {
            $page = $this->_request->getParam('post_user_id');
            $type = "events";            
            $data = array(
                'name' => 'string',//string //Event name
                'start_time' => '',//UNIX timestamp //Event start time
                'end_time' => '',//UNIX timestamp //Event start time
                'description' => '',//string //Event description
                'location' => '',//string //Event location
                'privacy_type' => '',//string contain 'OPEN' (default), 'CLOSED', or 'SECRET' //Event privacy setting
            );
	
            $event_post = $this->_postPage($page, $type, $data);
            if($event_post){
                echo $event_post['id'];
                exit();
            }
        } catch (FacebookApiException $e) {
            echo $e;
            exit();
        }           
    }
    
    public function milestoneAction(){
        /**Note
          *Test ok but can't post with images???
          */
        try {
            $page_id = $this->_request->getParam('page_id_mile');
            $title = $this->_request->getParam('title_mile');
            $des = $this->_request->getParam('description_mile');
            $time = $this->_request->getParam('time_mile');
            $type = "milestones";            
            $data = array(
                'title' => $title,//string //The title of the milestone
                'description' => $des,//string //The description of the milestone
                'start_time' => $time,//date/time format ISO-8601 //The start time of the milestone. A Page's milestones have the same start and end time.        
            );
            $page_info = Fb_Facebook::api($page_id."?fields=access_token");
            if( !empty($page_info['access_token']) ) {
        	$data['access_token'] = $page_info['access_token'];
                $post = new Application_Model_Facebook_Post();
                $milestone_post = $post->createPost($page_id, $type, $data);
            
                if($milestone_post){
                    echo $milestone_post['id'];
                    exit();
                }
                else{
                    echo 'fail';
                    exit();
                }
            }
            else{
                echo "empty access token";
            }
        } catch (FacebookApiException $e) {
            echo $e;
            exit();
        }           
    }
    
    public function questionAction(){
        /**Note
          *Test ok
          */  
        try {
            $page_id = $this->_request->getParam('page_id_poll');
            $question = $this->_request->getParam('question');
            $op1 = $this->_request->getParam('op1');
            $op2 = $this->_request->getParam('op2');
            $type = "questions";            
            $data = array(
                'question' => $question,//string //The text of the question 
                'options' => array($op1, $op2),//array //Array of answer options 
//                'allow_new_options' => true,//boolean //Allows other users to add new options (True by default) 
//                'published' => true,//boolean //Whether a post is published. Default is published. This field is `not` supported when actions parameter is specified. 
//                'scheduled_publish_time' => '',//UNIX timestamp //Time when the page post should go live, this should be between 10 mins and 6 months from the time of publishing the post.
            );
	    $page_info = Fb_Facebook::api($page_id."?fields=access_token");
            if( !empty($page_info['access_token']) ) {
        	$data['access_token'] = $page_info['access_token'];
                $post = new Application_Model_Facebook_Post();
                $question_post = $post->createPost($page_id, $type, $data);
                if($question_post){
                    echo $question_post['id'];
                    exit();
                }
                else{
                    echo 'fail';
                    exit();
                }
            }
            else{
                echo "empty access token";
            }
        } catch (FacebookApiException $e) {
            echo $e;
            exit();
        }                
    }
    
    
}

