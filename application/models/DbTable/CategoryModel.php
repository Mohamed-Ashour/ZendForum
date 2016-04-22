<?php

class Application_Model_DbTable_CategoryModel extends Zend_Db_Table_Abstract
{

    protected $_name = 'category';

    public function addCategory($data){
    	if (isset($data['module']))
        unset( $data['module']) ;
      if (isset($data['controller']))
        unset( $data['controller']);
      if (isset($data['action']))
        unset( $data['action']);
      if (isset($data['submit']))
        unset( $data['submit']);

    return $this->insert($data);
   }

    public function editCategory($data,$id){
    	//$id = $data['id'];
      if (isset($data['module']))
      unset( $data['module']) ;
    if (isset($data['controller']))
      unset( $data['controller']);
    if (isset($data['action']))
      unset( $data['action']);
    if (isset($data['submit']))
      unset( $data['submit']);
     // if (isset($data['id']))
     //unset( $data['id']);

      return $this->update( $data, 'id='.$id);
    }

    public function deleteCategory($id){
    	$this->delete("id=" . $id);
    }

	public function selectAllCategory(){
		 return $this->fetchAll()->toArray();

    }

    public function selectCategoryById($id){
    	return $this->find($id)->toArray();
    } 
}

