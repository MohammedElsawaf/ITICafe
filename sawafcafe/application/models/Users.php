<?php
class Application_Model_Users extends Zend_Db_Table_Abstract
{
    protected $_name= 'users' ;
    
    function addUser($data){
        $data['password'] = md5($data['password']);
        return $this->insert($data);

    }
    
    function listUsers(){
        
        return $this->fetchAll()->toArray();

    }
    
    function getUser($id){
        return $this->fetchAll("user_id=$id")->toArray();
    }
    
    function deleteUser($id){
        $this->delete("user_id=$id");
    }


    function editUser($id, $user_data){
        $this->update($user_data, "user_id=$id");
    }
    
    
    //new added

}