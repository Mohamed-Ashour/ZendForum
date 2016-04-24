<?php

class IndexController extends Zend_Controller_Action
{


    public function init()
    {

    }

    public function indexAction()
    {
		$this->redirect('index.php/home');
    }


}
