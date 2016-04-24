<?php

class ThreadsController extends Zend_Controller_Action
{

    private $model = null;
    public static $ForumsModel;
    public static $CategoryModel;
    public static $UserModel ;
	private $identity = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_ThreadModel();
        $this->ForumsModel = new Application_Model_DbTable_ForumModel();
        $this->CategoryModel = new Application_Model_DbTable_CategoryModel();
        $this->UserModel = new Application_Model_DbTable_UserModel();
		$this->identity = Zend_Auth::getInstance()->getIdentity();
		if (isset($this->identity)) {
			$this->view->identity = $this->identity;
		}
    }

	public function userThreads()
    {
        $id = $this->getRequest()->getParam('id');
		$threads = $this->model->getForumThreads($id);
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

        // action body

        $category_info  = $this->model->listThreads();
        for ($i=0; $i < count($category_info); $i++) {
            $name = $this->CategoryModel->selectCategoryById($category_info[$i]['category_id'])[0]['name'];
           $category_info[$i]['category'] = $name;
        }

        $forum_info  = $this->model->listThreads();
        for ($i=0; $i < count($forum_info); $i++) {
            $nameforum = $this->ForumsModel->selectForumById($forum_info[$i]['forum_id'])[0]['name'];
           $forum_info[$i]['forum'] = $nameforum;
        }

        $user_info = $this->model->listThreads();
        for ($i=0; $i <count($user_info) ; $i++) {
            # code...
            $username= $this->UserModel->getUserById($user_info[$i]['user_id'])[0]['username'];
            $user_info[$i]['username'] = $username;
        }

        $this->view->users=$user_info;
        $this->view->forums= $forum_info ;
        $this->view->categories= $category_info ;
        $this->view->threads = $this->model->listThreads();

    }

    public function addAction()
    {
        $data = $this->getRequest()->getParams();
        $form = new Application_Form_Thread();

		if (isset($this->identity)) {
			if (!$this->identity->is_admin) {
				$form->removeElement('is_sticky');
				$form->removeElement('is_opened');
			}
		}
		else {
			$this->redirect('home');
		}

        $categories = $this->CategoryModel->selectAllCategory();

        for ($i=0; $i < count($categories); $i++) {
            $options[$categories[$i]['id']] = $categories[$i]['name'];
        }
        $form->category_id->addMultiOptions($options);

        $forums = $this->ForumsModel->selectAllForum();

        for ($i=0; $i < count($forums); $i++) {
            $options[$forums[$i]['id']] = $forums[$i]['name'];
        }
        $form->forum_id->addMultiOptions($options);


        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $storage->read();
        $userId=$storage->read()->id;
        echo "this is the logged user idees ".$userId;
        $this->view->id=$userId;

        if($this->getRequest()->isPost()){

            if($form->isValid($data)){
            if ($this->model->addThread($userId,$data))
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

		if (isset($this->identity)) {
			if (!$this->identity->is_admin) {
				$form->removeElement('is_sticky');
				$form->removeElement('is_open');
			}
		}
		else {
			$this->redirect('home');
		}

        $categories = $this->CategoryModel->selectAllCategory();

        for ($i=0; $i < count($categories); $i++) {
            $options[$categories[$i]['id']] = $categories[$i]['name'];
        }
        $form->category_id->addMultiOptions($options);

        $forums = $this->ForumsModel->selectAllForum();

        for ($i=0; $i < count($forums); $i++) {
            $options[$forums[$i]['id']] = $forums[$i]['name'];
        }
        $form->forum_id->addMultiOptions($options);


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
