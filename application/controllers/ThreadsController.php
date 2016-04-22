<?php

class ThreadsController extends Zend_Controller_Action
{

    private $model = null;
    
    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_ThreadModel();
        
    }

    public function indexAction()
    {
        // action body
        $this->view->threads = $this->model->listThreads();
    }

    public function addAction()
    {
        // action body
        
        $data = $this->getRequest()->getParams();
        $form = new Application_Form_Thread();
        
        if($this->getRequest()->isPost()){
            
            if($form->isValid($data)){
            if ($this->model->addThread(1,$data))
            $this->redirect('threads/index');
            }   
        }

        //$this->view->flag = 1;
        $this->view->form = $form;
        $this->render('form');

    }

    public function editAction()
    {
        // action body
        $id = $this->getRequest()->getParam('id');
        
        $form = new Application_Form_Thread();
        
        $thread = $this->model->getThreadById($id);
        $form->populate($thread[0]);
        print_r($thread[0]);
        //$form->setAction("users/index");
        $this->view->form = $form;
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getParams();
            if($form->isValid($data)){
                if ($this->model->editThread($id , $data))
                    $this->redirect('threads/index');
            }   
        }   
        
        $this->render('form');
    }

    public function deleteAction()
    {
        // action body
        $id = $this->getRequest()->getParam('id');
        
        if($id){
         if ($this->model->deleteThread($id))
            $this->redirect('threads/index');
            
        } else {
            $this->redirect('threads/index');
        }
    }


}







