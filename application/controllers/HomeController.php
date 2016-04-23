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
		$categories=$this->CategoryModel->selectAllCategory();

		for ($i=0; $i < count($categories) ; $i++) {
			$categories[$i]['forums'] = $this->ForumsModel->getCategoryForum($categories[$i]['id']);

			for ($j=0; $j < count($categories[$i]['forums']) ; $j++) {
				$categories[$i]['forums'][$j]['threads_count'] = count($this->ThreadModel->getForumThreads($categories[$i]['forums'][$j]['id']));
			}
		}


		$this->view->categories = $categories;

    }


}
