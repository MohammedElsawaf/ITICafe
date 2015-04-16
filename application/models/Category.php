<?php

class Application_Model_Category extends Zend_Db_Table_Abstract
{
    protected $_name="category";
    function addCategory($data)
    {
        return $this->insert($data);
    }
    function listCategory()
    {
        return $this->fetchAll()->toArray();
    }
    function deleteCategory($id)
    {
        return $this->delete("category_id=".$id);
    }
    function getCategoryById($id)
    {
        return $this->find($id)->toArray();
    }
    function editCategory($data)
    {
        return $this->update($data,"category_id=".$data["category_id"]);
    }
    function listCategoryName()
    {
        $select=$this->select()->from("category",array("category_name"));
        return $this->fetchAll($select)->toArray();
    }
}
{


}

