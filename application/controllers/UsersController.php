<?php

class UsersController extends Zend_Controller_Action
{

    private $userModel = null;
	private $identity = null;
	private $SystemModel = null;

    public function init()
    {
        $this->userModel = new Application_Model_DbTable_UserModel();
		$this->SystemModel = new Application_Model_DbTable_SystemModel();
		$this->identity = Zend_Auth::getInstance()->getIdentity();
		if (isset($this->identity)) {
			$this->view->identity = $this->identity;
		}
    }

    public function indexAction()
    {
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

		$this->view->title = 'Users';
        $this->view->users = $this->userModel->listUsers();

    }

    public function addAction()
    {

    	$data = $this->getRequest()->getParams();
        $form = new Application_Form_Registeration();

		if (!isset($this->identity) || !$this->identity->is_admin) {
			$form->removeElement('is_admin');
			$form->removeElement('is_banned');
		}

        $form->email->addValidator(new Zend_Validate_Db_NoRecordExists(
            array(
              'table' => 'user',
              'field' => 'email'
            )
        ));
        $form->username->addValidator(new Zend_Validate_Db_NoRecordExists(
            array(
              'table' => 'user',
              'field' => 'username'
            )
        ));

        $this->view->form = $form;
        if($this->getRequest()->isPost()){
            if($form->isValid($data)){
                if($form->getElement('image')->receive())
                {
					$message = "this is your registeratio info\n username = ".$data['username']."\n your password is ". $data['username'];
					$mail = new Zend_Mail();
					$mail->setBodyText($message);
					$mail->setFrom('admin@3adellaa.com');
					$mail->addTo($data['email']);
					$mail->setSubject('Registeration message');
					$mail->send();
                    $data['image'] = 'uploads/images/' . $form->getElement('image')->getValue();

                    if ($this->userModel->addUser($data))
                        $this->redirect('users');
                }
            }
        }
		$this->view->title = 'Add User';
        $this->render('form');
    }

    public function editAction()
    {

        $id = $this->getRequest()->getParam('id');
        $form = new Application_Form_Registeration();

		if (!isset($this->identity) || !$this->identity->is_admin) {
			$form->removeElement('is_admin');
			$form->removeElement('is_banned');
		}


        $user = $this->userModel->getUserById($id);
        $form->populate($user[0]);
        $this->view->form = $form;

        if($this->getRequest()->isPost()){
			$data = $this->getRequest()->getPost();

			if($form->getElement('image')->receive())
			{
				$data['image'] = 'uploads/images/' . $form->getElement('image')->getValue();

				if($form->isValid($data)){
					if ($this->userModel->editUser($data, $id))
					$this->redirect('users');
				}
			}

        }
		$this->view->title = 'Edit User';
        $this->render('form');
    }

    public function deleteAction()
    {
		if (isset($this->identity)) {
			if ($this->identity->is_admin) {
				$this->view->identity = $this->identity;
			}
			else {
				$this->redirect('home');
			}
		}
		else {
			$this->redirect('home');
		}

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


				$this->redirect('home');

            }else{
                echo "<p>user doesnt exist !!</p>" ;
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
