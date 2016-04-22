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
		$row->forum_id=$data['forum_id'];
		$row->user_id=$userId;
		$row->category_id=$data['category_id'];

		return $row->save();
	
	}


	function listThreads(){
		return $this->fetchAll()->toArray();
	}


	function deleteThread($id){
		return $this->delete('id='.$id);
	}

	function getThreadById($id){
		return $this->find($id)->toArray();
	}

	function editThread($id, $data){
	
		if (isset($data['module']))  
			unset( $data['module']) ;
		if (isset($data['controller'])) 
	 		unset( $data['controller']);
		if (isset($data['action']))
			unset( $data['action']);
		if (isset($data['submit']))
			unset($data['submit']);
		
		$id = $data['id'];
		// if(isset($data['id']))
		// 	unset( $data['id']);

		//$data['password']=md5($data['password']);
		 
		return $this->update($data,"id=".$id);
		
	}

}

