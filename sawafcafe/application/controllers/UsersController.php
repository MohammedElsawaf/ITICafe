<?php

require_once 'AdminController.php';

class UsersController extends AdminController
{

    public function indexAction()
    {
        $user_model = new Application_Model_Users();

        $this->view->users = $user_model->listUsers(); 
    }

     public function editAction() {
        $this->view->action = "Edit User";
        $this->view->js = "editUser";
        $id = $this->getRequest()->getParam("id");
        $user_model = new Application_Model_Users();
        $form = new Application_Form_User($this->view->baseUrl());
        $form->getElement("password")->setRequired(false);
        $form->getElement("cpassword")->setRequired(false);
        $form->getElement("email")->addValidator(
                                        new Zend_Validate_Db_NoRecordExists(
                                                array(
                                                    "table"=>"users",
                                                    "field"=>"email",
                                                    'exclude' => array ('field' => 'user_id','value' => $id)
                                    )));
        $user_info = $user_model->getUser($id);
        
        $form->populate($user_info[0]);
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getParams())) {
            $data = $form->getValues();
            if($data['image'] === NULL){
                unset($data['image']);
            }
                
            if($data['password'] !== $data['cpassword']){
                $this->view->confirm = "The two words doesn't match"; 
            }else{
                if($data['password'] === "")
                    {
                    unset($data['password']);
                }else{
                    $data['password'] = md5($data['password']);
                }
                unset($data['cpassword']);
                if($user_model->editUser($id,$data)){
                    if(isset($data['image'])){
                        $upload = new Zend_File_Transfer_Adapter_Http();
                        $upload->receive();
                    }
                    $this->redirect("admin/indexuser");
                }else{
                    $this->redirect("admin/indexuser");
                }
            }
        }
        $this->render("add");
    }


}




