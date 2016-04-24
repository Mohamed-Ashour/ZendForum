<?php

class SystemController extends Zend_Controller_Action
{

	private $SystemModel;
	private $identity = null;

    public function init()
    {
        $this->SystemModel = new Application_Model_DbTable_SystemModel();
		$this->identity = Zend_Auth::getInstance()->getIdentity();
    }

    public function indexAction()
    {
        $this->SystemModel->changeState();
		$this->redirect('Admin');
    }


}
