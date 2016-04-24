<?php

class HomeController extends Zend_Controller_Action
{

    public static $ForumsModel = null;

    public static $CategoryModel = null;

    public static $UserModel = null;

    public static $ThreadModel = null;

    public static $ReplyModel = null;

    private $identity = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->ThreadModel = new Application_Model_DbTable_ThreadModel();
        $this->ForumsModel = new Application_Model_DbTable_ForumModel();
        $this->CategoryModel = new Application_Model_DbTable_CategoryModel();
        $this->UserModel = new Application_Model_DbTable_UserModel();
        $this->ReplyModel = new Application_Model_DbTable_ReplyModel();
		$this->userModel = new Application_Model_DbTable_UserModel();
		$this->SystemModel = new Application_Model_DbTable_SystemModel();
		$this->identity = Zend_Auth::getInstance()->getIdentity();
		if (isset($this->identity)) {
			$this->view->identity = $this->identity;
		}
    }

    public function indexAction()
    {
        // action body
		if (isset($this->identity)) {
			if (!$this->SystemModel->getState() && !$this->identity->is_admin) {
				echo "<div class='panel-danger'>System is off now</div>";
				return;
			}
			elseif ($this->identity->is_banned) {
				echo "<p>you are banned</p>";
				return;
			}

		}
		$this->view->system = 1;
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
        //$this->view->threads = $this->ThreadModel->listThreads();

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

        
        
        $stickyThreads=$this->ThreadModel->listStickyThreads();
        $nonStickyThreads=$this->ThreadModel->listNonStickyThreads();
        //echo var_dump($stickyThreads);
        //echo var_dump($nonStickyThreads);

		$this->view->forums = $forums;
        $this->view->stickyThreads = $stickyThreads;
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
		if (isset($storage->read()->id)) {
			$userId=$storage->read()->id;
		}



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

    public function deleteAction()
    {
        // action body
        $id = $this->getRequest()->getParam('id');
        echo "reply id el mafrood" . $id ;
        if($id){
            $threadId = $this->ReplyModel->getThreadIdFromReply($id);
         if ($this->ReplyModel->deleteReply($id))
            
            $this->redirect('home/thread/id/'.$threadId[0]['thread_id']);
                            
            
        } else {
            //$this->redirect("blog-x/details/id/".$postId['post_id']);
            $this->redirect('home/thread/id/'.$threadId['thread_id']);
        }
    }

    public function editAction()
    {
        // action body
        $replyId = $this->getRequest()->getParam('id');
        $threadId = $this->ReplyModel->getThreadIdFromReply($replyId);
        
        $form = new Application_Form_Reply();
        
        $reply = $this->ReplyModel->getReplyById($threadId);
        $form->populate($reply[0]);
        print_r($reply[0]);
        //$form->setAction("users/index");
        $this->view->form = $form;
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getParams();
            if($form->isValid($data)){
                if ($this->ReplyModel->editReply($threadId , $data))
                    $this->redirect('home/thread/id/'.$threadId['thread_id']);
            }   
        }   
        
        $this->render('form');
    }


}




