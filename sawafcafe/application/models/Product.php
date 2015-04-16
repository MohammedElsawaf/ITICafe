<?php

class Application_Model_Product extends Zend_Db_Table_Abstract
{
    protected $_name="product";
    function addProduct($data)
    {
        return $this->insert($data);
    }
    function listProduct()
    {
        return $this->fetchAll()->toArray();
    }
    function deleteProduct($id)
    {
        return $this->delete("product_id=".$id);
    }
    function getProductById($id)
    {
        return $this->find($id)->toArray();
    }
    function editProduct($data)
    {
        return $this->update($data,"product_id=".$data["product_id"]);
    }
}

