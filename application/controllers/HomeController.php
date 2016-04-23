<?php

class HomeController extends Zend_Controller_Action
{

	public static $ForumsModel;
    public static $CategoryModel;
    public static $UserModel ;
    public static $ThreadModel ;
    public function init()
    {
        /* Initialize action controller here */
        $this->ThreadModel = new Application_Model_DbTable_ThreadModel();
        $this->ForumsModel = new Application_Model_DbTable_ForumModel();
        $this->CategoryModel = new Application_Model_DbTable_CategoryModel();
        $this->UserModel = new Application_Model_DbTable_UserModel();

    }

    public function indexAction()
    {
        // action body
        $this->view->threads = $this->ThreadModel->listThreads();
        $this->view->categories=$this->CategoryModel->selectAllCategory();
        $this->view->forums=$this->ForumsModel->selectAllForum();
        $this->view->countForums=$this->ForumsModel->countCategoryForum(2);
    }


}

