<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');

		$this->addElement('text', 'username',
			array(
			'label' => 'Username:',
			'required' => true,
			'filters' => array('StringTrim'),
			'class' => 'form-control'
			)
		);

		$this->addElement('password', 'password',
			array(
			'label' => 'Password:',
			'required' => true,
			'class' => 'form-control'
			)
		);
		$this->addElement('submit', 'submit', array(
			'ignore'=> true,
			'label'=> 'Login',
			'class'=> 'btn btn-primary'
			)
		);

    }


}
