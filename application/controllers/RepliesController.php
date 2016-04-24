<?php

class RepliesController extends Zend_Controller_Action
{
	private $identity = null;
	private $model;
    public function init()
    {
        $this->identity = Zend_Auth::getInstance()->getIdentity();
		$this->model = new Application_Model_DbTable_ReplyModel();
    }

	public function addAction()
    {
    	$data = $this->getRequest()->getParams();
        $form = new Application_Form_Reply();

        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $storage->read();
        $userId=$storage->read()->id;
        

        $this->view->form = $form;
        if($this->getRequest()->isPost()){
            if($form->isValid($data)){
                if ($this->model->addReply($data , $user_id , $thread_id))
                    $this->redirect('home/thread');
            }
        }
        $this->render('form');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $form = new Application_Form_Reply();
        $reply = $this->model->getReplyById($id);
		$post_id = $reply[0]['post_id'];
        $form->populate($reply[0]);
        $this->view->form = $form;

        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            if($form->isValid($data)){
                if ($this->model->editReply($data))
                    $this->redirect('posts/show/id/'.$post_id);
            }
        }

        $this->render('form');
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($id){
            if ($this->model->deleteReply($id))
                $this->redirect('replies');

        } else {
            $this->redirect('replies');
        }
    }

    public function postRepliesAction()
    {
		$post_id = $this->getRequest()->getParam('post');
        $this->view->replies = $this->model->listReplies($post_id);

    }


}
