<?php

class ForumsController extends Zend_Controller_Action
{
    public static $ForumsModel;
    public static $CategoryModel;
	private $identity = null;



    public function init()
    {
      	$this->identity = Zend_Auth::getInstance()->getIdentity();
        $this->ForumsModel = new Application_Model_DbTable_ForumModel();
        $this->CategoryModel = new Application_Model_DbTable_CategoryModel();

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

       $this->view->name = 'forums';
       $forums_info  = $this->ForumsModel->selectAllForum();
       for ($i=0; $i < count($forums_info); $i++) {
            $name = $this->CategoryModel->selectCategoryById($forums_info[$i]['category_id'])[0]['name'];
           $forums_info[$i]['category'] = $name;
       }
       $this->view->forums= $forums_info ;

    }

    public function addAction()
    {

        $form = new Application_Form_Forum();
        $categories = $this->CategoryModel->selectAllCategory();

        for ($i=0; $i < count($categories); $i++) {
            $options[$categories[$i]['id']] = $categories[$i]['name'];
        }
        $form->category_id->addMultiOptions($options);


        $this->view->form = $form;
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getParams();
            if($form->isValid($data)){
                if ($this->ForumsModel->addForum($data))
                    $this->redirect('forums');
            }
        }
        $this->render('form');
    }

    public function editAction()
    {
     
        $id = $this->getRequest()->getParam('id');

        $form = new Application_Form_Forum();
        $categories = $this->CategoryModel->selectAllCategory();

        for ($i=0; $i < count($categories); $i++) {
            $options[$categories[$i]['id']] = $categories[$i]['name'];
        }
        $form->category_id->addMultiOptions($options);

        $Forum = $this->ForumsModel->selectForumById($id);


        $category_id = $Forum[0]['category_id'];

        $form->populate($Forum[0]);
        $this->view->form = $form;



        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            if($form->isValid($data)){
                if ($this->ForumsModel-> editForum($data))
                    $this->redirect('forums');
            }
        }

        $this->render('form');


    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($id){
            if ($this->ForumsModel->deleteForum($id))
                $this->redirect('forums');

        } else {
            $this->redirect('forums');
        }
    }

    public function CategoryForumAction()
    {
        $category_id = $this->getRequest()->getParam('category');
        $this->view->Forum = $this->ForumsModel->selectAllForum($category_id);

    }



}
