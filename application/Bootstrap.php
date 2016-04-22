<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initPlaceholders()
	{
		// 
		// $this->bootstrap('frontcontroller');
		// $controller = Zend_Controller_Front::getInstance();
		// $controller->setBaseUrl('/zend_pojects/ZendForum/public/');

		function _initSession(){
			Zend_Session::start();
			$session = new
			Zend_Session_Namespace( 'Zend_Auth' );
			$session->setExpirationSeconds( 1800 );
		}

	}

}
