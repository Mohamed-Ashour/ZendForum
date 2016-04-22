<?php

class SystemController extends Zend_Controller_Action
{

	private $SystemModel;

    public function init()
    {
        $this->SystemModel = new Application_Model_DbTable_SystemModel();
    }

    public function indexAction()
    {
        $this->SystemModel->changeState();
		$this->redirect('Admin');
    }


}
