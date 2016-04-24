<?php

class SystemController extends Zend_Controller_Action
{

	private $SystemModel;
	private $identity = null;

    public function init()
    {
        $this->SystemModel = new Application_Model_DbTable_SystemModel();
		$this->identity = Zend_Auth::getInstance()->getIdentity();
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
        $this->SystemModel->changeState();
		$this->redirect('Admin');
    }


}
