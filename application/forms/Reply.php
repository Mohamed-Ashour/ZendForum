<?php

class Application_Form_Reply extends Zend_Form
{

	public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $this->setMethod('post');
        //$this->setAction('index.php/Replies/add');

		$text = new Zend_Form_Element_Textarea("text");
		$text->setRequired();
		$text->setAttrib('rows', '6');
		$text->setAttrib('cols', '15');
		$text->setAttrib('class', 'form-control');
		$text->setAttrib("placeholder","Enter your reply");



		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib("class","btn btn-success");


		$this->addElements(array( $text, $submit));
    }


}
