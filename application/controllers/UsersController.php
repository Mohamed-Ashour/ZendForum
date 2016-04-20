<?php

class UsersController extends Zend_Controller_Action
{
	private $userModel;

    public function init()
    {
        $this->userModel = new Application_Model_DbTable_UserModel();
    }

    public function indexAction()
    {
		$this->view->title = 'Users';
        $this->view->users = $this->userModel->listUsers();
    }

    public function addAction()
    {
    	$data = $this->getRequest()->getParams();
        $form = new Application_Form_Registeration();
        $form->email->addValidator(new Zend_Validate_Db_NoRecordExists(
            array(
              'table' => 'user',
              'field' => 'email'
            )
        ));
        $this->view->form = $form;
        if($this->getRequest()->isPost()){
            if($form->isValid($data)){
                if ($this->userModel->addUser($data))
                    $this->redirect('users');
            }
        }
		$this->view->title = 'Add User';
        $this->render('form');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $form = new Application_Form_User();

        $user = $this->userModel->getUserById($id);
        $form->populate($user[0]);
        $this->view->form = $form;

        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            if($form->isValid($data)){
                if ($this->userModel->editUser($data))
                    $this->redirect('users');
            }
        }
		$this->view->title = 'Edit User';
        $this->render('form');
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($id){
            if ($this->userModel->deleteUser($id))
                $this->redirect('users');

        } else {
            $this->redirect('users');
        }
    }
    public function loginAction()
    {
        // action body
    }


}
