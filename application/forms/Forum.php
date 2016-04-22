<?php

class Application_Form_Forum extends Zend_Form
{

    public function init()
    {
       $id = new Zend_Form_Element_Hidden("id");
		$id->removeDecorator('label');
		$category_id = new Zend_Form_Element_Hidden("category_id");
		$category_id->removeDecorator('label');

		$name = new Zend_Form_Element_Text("name");
		$name->setRequired();
		$name->setlabel("Title:");
		$name->setAttrib("class","form-control");
		$name->setAttrib("placeholder","Enter your Forum Name");

		$descreption = new Zend_Form_Element_Textarea("descreption");
		$descreption->setRequired();
		$descreption->setlabel("Descreption:");
		$descreption->setAttrib("class","form-control");
		$descreption->setAttrib("placeholder","Enter your comment");
		$descreption->setAttrib("rows","6");

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib("class","btn btn-success");

		$this->addElements(array($id, $category_id,$name, $descreption, $submit));
    }


}

