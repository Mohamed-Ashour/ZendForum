<?php

class Application_Form_Thread extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        
        //$userId = new Zend_Form_Element_Hidden("user_id");

		$title = new Zend_Form_Element_Text("title");
		$title->setRequired();
		//$title->addValidator(new Zend_Validate_Alpha());
		$title->setlabel("Title:");
		$title->setAttrib("class","form-control");
		$title->setAttrib("placeholder","Enter your title");

		$body = new Zend_Form_Element_Textarea("body");
		$body->setRequired();
		$body->setAttrib('rows', '9');
		$body->setAttrib('cols', '33');
		$body->setAttrib("placeholder","Enter body of thread");
		// $is_sticky = new Zend_Form_Element_MultiCheckbox('is_sticky', array(
		//     'multiOptions' => array(
		//         '1' => 'sticky',
		//     )
		// ));
		// $is_sticky->setlabel("is sticky :");
		// $is_sticky->setAttrib('class','form-control');


		$is_opened = new Zend_Form_Element_Select("	is_opened");
		$is_opened->setRequired();
		$is_opened->setlabel("is open :");
		$is_opened->addMultiOptions(array('1' => 'opened',
										 '0' => 'closed'
										)
									);
		$is_opened->setAttrib("class","form-control");
		//$is_opened->setAttrib("placeholder","Choose your category");


		$is_sticky = new Zend_Form_Element_Select("	is_sticky");
		$is_sticky->setRequired();
		$is_sticky->setlabel("is open :");
		$is_sticky->addMultiOptions(array('1' => 'sticky',
										 '0' => 'not sticky :v '
										)
									);
		$is_sticky->setAttrib("class","form-control");
		//$is_sticky->setAttrib("placeholder","Choose your category");


		// $is_opened = new Zend_Form_Element_MultiCheckbox('is_opened', array(
		//     'multiOptions' => array(
		//         '1' => 'opened',
		//     )
		// ));
		// $is_opened->setlabel("is opened :");
		// $is_opened->setAttrib('class','form-control');


		$forumId = new Zend_Form_Element_Select("forum_id");
		$forumId->setRequired();
		//$forumId->addValidator(new Zend_Validate_Alpha());
		$forumId->setlabel("forum id:");
		$forumId->setAttrib("class","form-control");
		$forumId->setAttrib("placeholder","Enter your forum Id");


		// $categoryId = new Zend_Form_Element_Text("category_id");
		// $categoryId->setRequired();
		// //$categoryId->addValidator(new Zend_Validate_Alpha());
		// $categoryId->setlabel("category id:");
		// $categoryId->setAttrib("class","form-control");
		// $categoryId->setAttrib("placeholder","Enter your category Id");

		$categoryId = new Zend_Form_Element_Select("category_id");
		$categoryId->setRequired();
		$categoryId->setlabel("Category:");
		
		$categoryId->setAttrib("class","form-control");
		$categoryId->setAttrib("placeholder","Choose your category");




		$submit = new Zend_Form_Element_Submit('submit');

		$this->addElements(array( /* $id  , */ $title, $body , $is_sticky , $is_opened , $forumId , $categoryId , $submit));
    }


}

