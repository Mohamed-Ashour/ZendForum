<?php

class Application_Model_DbTable_ThreadModel extends Zend_Db_Table_Abstract
{

    protected $_name = 'thread';

    function addThread($userId,$data){
		
		$row = $this->createRow();
		$row->title=$data['title']; 
		$row->body =$data['body'];
		$row->is_sticky=$data['is_sticky'];
		$row->is_opened=$data['is_opened'];
		$row->forum_id=$data['forumId'];
		$row->user_id=$userId;
		$row->category_id=$data['categoryId'];

		return $row->save();
	
	}
}

