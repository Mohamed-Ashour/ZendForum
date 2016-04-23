<?php

class Application_Model_DbTable_ReplyModel extends Zend_Db_Table_Abstract
{

    protected $_name = 'reply';

	function listReplies()
    {
    	return $this->fetchAll()->toArray();
    }

	function listThreadReplies($thread_id)
    {
    	return $this->fetchAll("thread_id = $thread_id")->toArray();
    }


    function addReply($data, $user_id, $thread_id)
    {
    	if (isset($data['module']))
  			unset( $data['module']) ;
  		if (isset($data['controller']))
  	 		unset( $data['controller']);
  		if (isset($data['action']))
  		 	unset( $data['action']);
  		if (isset($data['submit']))
  		 	unset( $data['submit']);

		$data['user_id'] = $user_id;
		$data['thread_id'] = $thread_id;

		return $this->insert($data);
    }


    function editReply($data)
    {
    	$id = $data['id'];
    	if (isset($data['module']))
			unset( $data['module']) ;
		if (isset($data['controller']))
	 		unset( $data['controller']);
		if (isset($data['action']))
		 	unset( $data['action']);
		if (isset($data['submit']))
		 	unset( $data['submit']);
   		if (isset($data['id']))
		 	unset( $data['id']);

    	return $this->update( $data, 'id='.$id);
    }


    function deleteReply($id)
    {
    	return $this->delete('id='.$id);
    }


    function getReplyById($id)
    {
    	return $this->find($id)->toArray();
    }



}
