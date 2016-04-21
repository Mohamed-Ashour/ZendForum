<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        //echo "inside index controller action !!";

        $auth = Zend_Auth::getInstance();
		$storage = $auth->getStorage();
		$storage->read();

		//var_dump($storage->read());
		
		$username= $storage->read()->username;
		$id=$storage->read()->id;
		$email=$storage->read()->email;
		$gender=$storage->read()->gender;
		$country=$storage->read()->country;
		$signature=$storage->read()->signature;
		$image=$storage->read()->image;

		$this->view->username=$username;
		$this->view->id=$id;
		$this->view->email=$email;
		$this->view->image=$image;
		$this->view->signature=$signature;
		$this->view->country=$country;
		//die();
		$this->render();
    }


}

