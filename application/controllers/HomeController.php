<?php

class HomeController extends Zend_Controller_Action
{

    public static $ForumsModel = null;

    public static $CategoryModel = null;

    public static $UserModel = null;

    public static $ThreadModel = null;

    public static $ReplyModel = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->ThreadModel = new Application_Model_DbTable_ThreadModel();
        $this->ForumsModel = new Application_Model_DbTable_ForumModel();
        $this->CategoryModel = new Application_Model_DbTable_CategoryModel();
        $this->UserModel = new Application_Model_DbTable_UserModel();
        $this->ReplyModel = new Application_Model_DbTable_ReplyModel();
    }

    public function indexAction()
    {
        // action body
        $this->view->threads = $this->ThreadModel->listThreads();
		$categories=$this->CategoryModel->selectAllCategory();

		for ($i=0; $i < count($categories) ; $i++) {
			$categories[$i]['forums'] = $this->ForumsModel->getCategoryForum($categories[$i]['id']);

			for ($j=0; $j < count($categories[$i]['forums']) ; $j++) {
				$categories[$i]['forums'][$j]['threads_count'] = count($this->ThreadModel->getForumThreads($categories[$i]['forums'][$j]['id']));
			}
		}


		$this->view->categories = $categories;

    }

    public function forumAction()
    {
        $this->view->threads = $this->ThreadModel->listThreads();
	
		$forumId = $this->getRequest()->getParam('id');
		$forums=$this->ForumsModel->selectForumById($forumId)[0];
 	
		$forums['threads'] = $this->ThreadModel->getForumThreads($forums['id']);
       
		for ($j=0; $j < count($forums['threads']) ; $j++) {
			$forums['threads'][$j]['replys_count'] = count($this->ReplyModel->listThreadReplies($forums['threads'][$j]['id']));
		}
        for ($j=0; $j < count($forums['threads']); $j++) { 
        	$name = $this->UserModel->getUserById($forums['threads'][$j]['user_id'])[0]['username'];
    	    $forums['threads'][$j]['username'] = $name;
   		}	


	

		$this->view->forums = $forums;

    }

    public function threadAction()
    {
        // action body
        $threadId = $this->getRequest()->getParam('id');
        $thread=$this->ThreadModel->getThreadById($threadId)/*[0]*/;
        $userId=$thread[0]['user_id'];
        $name = $this->UserModel->getUserById($userId);
        $this->view->username=$name[0]['username'];
        $this->view->thread=$thread;
        //var_dump($thread);

        /* *************************************************** */
        
        $data = $this->getRequest()->getParams();
        $formReply = new Application_Form_Reply();

        //$this->view->form = $formReply;

        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $storage->read();
        $userId=$storage->read()->id;
        

        $this->view->form = $formReply;

        if($this->getRequest()->isPost()){
            if($formReply->isValid($data)){
                if ($this->ReplyModel->addReply($data , $userId , $threadId))
                    $this->redirect('home/thread/id/'.$threadId);
            }
        }
        //$this->render('form');        
        //$commentsX = $this->modelComment->listComments($id);
        $this->view->replies = $this->ReplyModel->listThreadReplies($threadId);
        
        
    }


}




