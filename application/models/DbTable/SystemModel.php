<?php

class Application_Model_DbTable_SystemModel extends Zend_Db_Table_Abstract
{

    protected $_name = 'system';

	function getState()
	{
		return $this->find(1)->toArray()[0]['is_opened'];
	}

	function changeState()
	{
		$state = $this->getState();
		if ($state == '0' ) {
			return $this->update( array('is_opened' => '1' ), 'id = 1');
		}
		else {
			return $this->update( array('is_opened' => '0' ), 'id = 1');
		}
	}

}
