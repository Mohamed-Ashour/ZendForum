<?php

class AdminController extends Zend_Controller_Action
{
	private $SystemModel;
	private $identity = null;

    public function init()
    {
		$this->identity = Zend_Auth::getInstance()->getIdentity();
		$this->SystemModel = new Application_Model_DbTable_SystemModel();
		$this->UserModel = new Application_Model_DbTable_UserModel();
		$this->CategoryModel = new Application_Model_DbTable_CategoryModel();
		$this->ForumModel = new Application_Model_DbTable_ForumModel();
		$this->ThreadModel = new Application_Model_DbTable_ThreadModel();
		$this->ReplyModel = new Application_Model_DbTable_ReplyModel();
		
		if (isset($this->identity)) {
			if ($this->identity->is_admin == '1') {
				$this->view->identity = $this->identity;
			}
			else {
				$this->redirect('home');
			}
		}
		else {
			$this->redirect('home');
		}
    }

	public function indexAction()
    {

		$this->view->usersCount = count($this->UserModel->listUsers());
		$this->view->categoriesCount = count($this->CategoryModel->selectAllCategory());
		$this->view->forumsCount = count($this->ForumModel->selectAllForum());
		$this->view->threadsCount = count($this->ThreadModel->listThreads());
		$this->view->repliesCount = count($this->ReplyModel->listReplies());

		$this->view->state = $this->SystemModel->getState();
    }

}
