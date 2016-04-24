<?php

class Application_Model_DbTable_ThreadModel extends Zend_Db_Table_Abstract
{

    protected $_name = 'thread';

    function addThread($userId,$data){
		if (isset($data['module']))
			unset( $data['module']) ;
		if (isset($data['controller']))
	 		unset( $data['controller']);
		if (isset($data['action']))
			unset( $data['action']);
		if (isset($data['submit']))
			unset($data['submit']);

		$data['user_id'] = $userId;
		return $this->insert($data);


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

	public function getForumThreads($forum_id) {
       return $this->fetchAll("forum_id=$forum_id")->toArray();
    }

}
