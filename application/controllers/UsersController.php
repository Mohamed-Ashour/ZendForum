<?php

class UsersController extends Zend_Controller_Action
{

    private $userModel = null;

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
        $form = new Application_Form_Registeration();

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
        if($this->getRequest()->isPost()){
        
            $username= $this->_request->getParam('username'); // da gayly men el form 
            $password= $this->_request->getParam('password'); // da gayly men el form 
            
            // get the default db adapter
            $db =Zend_Db_Table::getDefaultAdapter();
            
            //create the auth adapter
            $authAdapter = new
            Zend_Auth_Adapter_DbTable($db,'user','username', 'password'); 
                                   //($db,'table_name' , 'user name' , 'password')
                                   // asama2hom fe le db
            
            //set the email and password
            $authAdapter->setIdentity($username); 
            $authAdapter->setCredential(md5($password));
            $result = $authAdapter->authenticate();
            
            if ($result->isValid()) {
        
                //if the user is valid register his info in session
                $auth = Zend_Auth::getInstance();
                $storage = $auth->getStorage();
                $storage->write($authAdapter->getResultRowObject(array('id' , 'email' , 'username' , 'password','image','country','gender','signature','is_admin','is_banned')));
                $this->redirect('index');
        

            }else{
                echo "user doesnt exist !!" ;
                $formLogObj = new Application_Form_Login();
                $this->view->form=$formLogObj;
            }

        }else{
            
            $formLogObj = new Application_Form_Login();
            $this->view->form=$formLogObj;
        }

    }

    public function logoutAction()
    {
        // action body
        Zend_Session::destroy();
        $this->redirect('users/login');
    }


}


