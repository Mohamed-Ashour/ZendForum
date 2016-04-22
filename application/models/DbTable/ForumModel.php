<?php

class Application_Model_DbTable_ForumModel extends Zend_Db_Table_Abstract
{

    protected $_name = 'forum';

    public function addForum($data){
       // unset($data['controller'], $data['action'], $data['module'], $data['submit']);
       //  $data['category_id'] = $category_id;
       // $this->insert($data);

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
    public function editForum($data){
       // unset($data['controller'], $data['action'], $data['module']);
       // $this->update($data, "id=" . $data['id']);
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

    public function deleteForum($id){
        return $this->delete('id='.$id);
    }

	public function selectAllForum(){
        return $this->fetchAll()->toArray();
    }

    public function selectForumById($id){
        return $this->find($id)->toArray();
    } 

    public function getCategoryForum($category_id) {
       return $this->fetchAll("category_id=$category_id")->toArray();
    }

    function countCategoryForum($category_id)
    {
        return count($this->fetchAll("category_id = $category_id")->toArray());
    }

    function deleteCategoryForum($category_id)
    {
        $categories = $this->fetchAll("category_id = $category_id")->toArray();
        for ($i=0; $i < count($categories) ; $i++) {
            $this->deleteForum( $categories[$i]['id'] );
        }
        return true;
    }


}

