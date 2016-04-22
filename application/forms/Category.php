<?php

class Application_Form_Category extends Zend_Form
{

    public function init()
    {
        $name = new Zend_Form_Element_Text("name");
		$name->setRequired();
		$name->setlabel("Title:");
		$name->setAttrib("class","form-control");
		$name->setAttrib("placeholder","Enter Category Name");


        $submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib("class","btn btn-success");
		$this->addElements(array($name,$submit));
    }


}

