<?php

class CategoriesController extends Zend_Controller_Action
{
    public static $CateModel = null;


    public function init()
    {
         $this->CateModel = new Application_Model_DbTable_CategoryModel();

    }

    public function indexAction()
    {
      // $Categories_info = CategoriesController::$CateModel->selectAllCategory();
        //$this->view->Categories =$Categories_info;

       $this->view->name = 'Categories';
       $Categories_info  = $this->CateModel->selectAllCategory();
       $this->view->Categories= $Categories_info ;
    }

    public function addAction()
    {
        $form = new Application_Form_Category();

        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParams();
            if ($form->isValid($data)) {
                if ($this->CateModel->addCategory($data))
                    $this->redirect('categories');
            }
        }

        $this->view->name = 'Add Category';
        $this->render('form');
     /* if ($this->getRequest()->isPost()) {
            $Category_info = $this->_request->getParams();
            CategoriesController::$CateModel->addCategory($Category_info);
            $this->redirect("categories/index");
        }*/

    }

    public function editAction()
    {
      /* if ($this->getRequest()->isPost()) {
            $Category_info = $this->_request->getParams();
            CategoriesController::$CateModel->editCategory($Category_info);
            $this->redirect("categories/index");
        } else {
            $Category_id = $this->_request->getParam("id");
            
            $this->view->Category_info = CategoriesController::$CateModel->selectCategoryById($Category_id);
        }*/

        $id = $this->getRequest()->getParam('id');
        $form = new Application_Form_Category();

        $Category = $this->CateModel->selectCategoryById($id);
        $form->populate($Category[0]);
        $this->view->form = $form;

        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            if($form->isValid($data)){
                if ($this->CateModel->editCategory($data,$id))
                    $this->redirect('categories');
            }
        }
        $this->view->name = 'Edit Category';
        $this->render('form');



    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($id){
            if ($this->CateModel->deleteCategory($id))
                $this->redirect('categories');

        } else {
            $this->redirect('categories');
        }
    }


      /* $this->_helper->viewRenderer->setNoRender(true);
        $Category_id = $this->_request->getParam("id");
        CategoriesController::$CateModel->deleteCategory($Category_id);
        $this->redirect("categories/index"); */

}






