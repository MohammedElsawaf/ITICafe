<?php

class Application_Model_Makeorder extends Zend_Db_Table_Abstract
{
    protected $_name= 'product' ;
    function listproduct(){
        
        return $this->fetchAll()->toArray();
    }
    function listAvailableProavailableducts(){
        //die(var_dump($this->fetchAll("avaliable=1")->toArray()));
        return $this->fetchAll("avaliable=1")->toArray();
    }
    function getProductById($id){
        return $this->find($id)->toArray();
    }
}

