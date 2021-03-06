<?php

class Application_Form_Registeration extends Zend_Form
{

    public function init()
    {
		$this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

		$username = new Zend_Form_Element_Text("username");
		$username->setRequired();
		$username->addValidator(new Zend_Validate_Alpha());
		$username->setlabel("Username:");
		$username->setAttrib("class","form-control");
		$username->setAttrib("placeholder","Enter your username");
		

		$email = new Zend_Form_Element_Text("email");
		$email->setRequired();
		$email->addValidator(new Zend_Validate_EmailAddress());
		
		$email->setlabel("Email:");
		$email->setAttrib("placeholder","Enter your Email");
		$email->setAttrib("class","form-control");

		$password = new Zend_Form_Element_Password("password");
		$password->setRequired();
		$password->setlabel("Password:");
		$password->setAttrib("placeholder","Enter your Password");
		$password->setAttrib("class","form-control");
		$password->addValidator(new Zend_Validate_StringLength(array('min' => 5)));

		$image = new Zend_Form_Element_File('image');
		$image->setlabel('Upload your image');
		$image->setDestination(APPLICATION_PATH.'/../public/uploads/images/');
		$image->setRequired(false);
		$image->addValidator('Extension', false, 'jpg,png,gif');
		$image->addValidator('Size', false, 2097152);
		$image->addValidator('Count', false, 1);
		$image->setAttrib("class","btn btn-success");
		$image->setValueDisabled(true);



		$country = new Zend_Form_Element_Select("country");
		$country->setRequired();
		$country->setlabel("Country:");
		$country->addMultiOptions(array('Egypt' => 'Egypt',
										 'America' => 'America',
										 'UAE' => 'UAE',
										 'KSA' => 'KSA')
									);
		$country->setAttrib("class","form-control");
		$country->setAttrib("placeholder","Choose your country");

		$gender = new Zend_Form_Element_Radio("gender");
		$gender->setRequired();
		$gender->setlabel("Gender:");
		$gender->addMultiOptions(array('Male' => ' Male',
										 'Female' => ' Female')
									);

		$signature= new Zend_Form_Element_Textarea("signature");
		$signature->setRequired();
		$signature->setAttrib('rows','7');
		$signature->setAttrib('cols','27');
		$signature->setAttrib('class','form-control');
		$signature->setlabel("signature :");
		$signature->setAttrib('placeholder','enter your signature');



		$is_admin = new Zend_Form_Element_Select('is_admin');
		$is_admin->addMultiOptions(array('0' => 'No',
										 '1' => 'Yes'
										)
									);
		$is_admin->setlabel("is admin :");
		$is_admin->setAttrib('class','form-control');


		$is_banned = new Zend_Form_Element_Select('is_banned');
		$is_banned->addMultiOptions(array('0' => 'No',
										 '1' => 'Yes'
										)
									);
		$is_banned->setlabel("is banned :");
		$is_banned->setAttrib('class','form-control');



		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib("class","btn btn-success");

		$this->addElements(array($username, $email, $password, $image, $country, $gender, $signature , $is_admin , $is_banned ,  $submit));
    }


}
