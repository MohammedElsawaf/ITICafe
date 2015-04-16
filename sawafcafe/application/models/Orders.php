<?php

class Application_Model_Orders extends Zend_Db_Table_Abstract
{
    
    protected $_name= 'orders' ;
    function addorder($data) {
        return  $this->insert($data); 
        
    }
    function listorder(){
        return $this->fetchAll()->toArray();
    }

}

