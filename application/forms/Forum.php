<?php

class Application_Form_Forum extends Zend_Form
{

    public function init()
    {
       $id = new Zend_Form_Element_Hidden("id");
		$id->removeDecorator('label');
		

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

		$category_id = new Zend_Form_Element_Select("category_id");
		$category_id->setRequired();
		$category_id->setlabel("Category:");
		
		$category_id->setAttrib("class","form-control");
		$category_id->setAttrib("placeholder","Choose your category");

		$is_opened = new Zend_Form_Element_Select("	is_opened");
		$is_opened->setRequired();
		$is_opened->setlabel("Check Forum:");
		$is_opened->addMultiOptions(array('1' => 'opened',
										 '0' => 'closed'
										)
									);
		$is_opened->setAttrib("class","form-control");
		$is_opened->setAttrib("placeholder","Choose your category");

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib("class","btn btn-success");

		$this->addElements(array($id, $name, $descreption, $category_id,$is_opened,$submit));
    }


}

