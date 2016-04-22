<?php

class ForumsController extends Zend_Controller_Action
{
    public static $ForumsModel;

    public function init()
    {
      /* if (empty(ForumsController::$ForumsModel)) {
            ForumsController::$ForumsModel = new Application_Model_DbTable_Comment();
        }*/
         $this->ForumsModel = new Application_Model_DbTable_ForumModel();
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        /* if ($this->getRequest()->isPost()) {
            $Forums_info = $this->_request->getParams();
            ForumsController::$ForumsModel->addComment($Forums_info);
            $topic_id = $comment_info['topic_id'];
            $this->redirect("post/single-post/id/$topic_id");
        }*/
        $data = $this->getRequest()->getParams();
        $form = new Application_Form_Forum();

        $this->view->form = $form;
        if($this->getRequest()->isPost()){
            if($form->isValid($data)){
                if ($this->ForumsModel->addForum($data))
                    $this->redirect('forums');
            }
        }
        $this->render('form');
    }

    public function editAction()
    {
       /*if ($this->getRequest()->isPost()) {
            $Forums_info= $this->_request->getParams();
            ForumsController::$ForumsModel->editForum($Forums_info);
            $category_id = $Forums_info['topic_id'];
            $this->redirect("post/single-post/id/$topic_id");
        }*/

        $id = $this->getRequest()->getParam('id');
        $form = new Application_Form_Forum();
        $Forum = $this->ForumsModel->selectForumById($id);
        //$category_id = $Forum[0]['category_id'];
        //$form->populate($Forum[0]);
        $this->view->form = $form;

        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            if($form->isValid($data)){
                if ($this->ForumsModel-> editForum($data))
                    $this->redirect('Categories/show/id/'.$category_id);
            }
        }

        $this->render('form');

       /* $id = $this->getRequest()->getParam('id');
        $form = new Application_Form_Forum();

        $Forum = $this->ForumsModel->selectForumById($id);
      //  $form->populate($Forum[0]);
        $this->view->form = $form;

        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            if($form->isValid($data)){
                if ($this->ForumsModel-> editForum($data))
                    $this->redirect('forums');
            }
        }
        $this->view->title = 'Edit Forum';
        $this->render('form');*/

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







