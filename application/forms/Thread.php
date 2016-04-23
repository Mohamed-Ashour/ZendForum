<?php

class Application_Form_Thread extends Zend_Form
{

    public function init()
    {

		$title = new Zend_Form_Element_Text("title");
		$title->setRequired();
		$title->setlabel("Title:");
		$title->setAttrib("class","form-control");
		$title->setAttrib("placeholder","Enter your title");

		$body = new Zend_Form_Element_Textarea("body");
		$body->setRequired();
		$body->setAttrib("class","form-control");
		$body->setAttrib('rows', '9');
		$body->setAttrib('cols', '33');
		$body->setAttrib("placeholder","Enter body of thread");


		$is_opened = new Zend_Form_Element_Select("	is_opened");
		$is_opened->setRequired();
		$is_opened->setlabel("is open :");
		$is_opened->addMultiOptions(array('1' => 'opened',
										 '0' => 'closed'
										)
									);
		$is_opened->setAttrib("class","form-control");


		$is_sticky = new Zend_Form_Element_Select("	is_sticky");
		$is_sticky->setRequired();
		$is_sticky->setlabel("is stickt :");
		$is_sticky->addMultiOptions(array(
										 '0' => 'normal',
										 '1' => 'sticky'
										)
									);
		$is_sticky->setAttrib("class","form-control");

		$forumId = new Zend_Form_Element_Select("forum_id");
		$forumId->setRequired();
		$forumId->setlabel("forum id:");
		$forumId->setAttrib("class","form-control");


		$categoryId = new Zend_Form_Element_Select("category_id");
		$categoryId->setRequired();
		$categoryId->setlabel("Category:");
		$categoryId->setAttrib("class","form-control");

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib("class","btn btn-success");


		$this->addElements(array( /* $id  , */ $title, $body , $is_sticky , $is_opened , $forumId , $categoryId , $submit));
    }


}
