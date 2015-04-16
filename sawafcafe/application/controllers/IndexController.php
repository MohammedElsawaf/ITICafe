<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity() && $this->_request->getActionName() !== 'login') {
            $this->redirect('index/login');
        }else{
            $this->_helper->layout->setLayout('layout');
        }
        
    }

    public function indexAction()
    {
        $order_model = new Application_Model_Order();
        $this->view->order = $order_model->getLastOrder(2, 1);
    }

    public function loginAction()
    {
        $this->_helper->layout->setLayout('login');
        $form = new Application_Form_Login($this->view->baseUrl());
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $this->view->data = "post";
            $email = $this->_request->getParam('email');
            $password = $this->_request->getParam('password');
            $db = Zend_Db_Table::getDefaultAdapter();
            $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'email', 'password');

            //set the email and password
            $authAdapter->setIdentity($email);
            $authAdapter->setCredential(md5($password));
            $result = $authAdapter->authenticate();
            $this->view->data = "ok";
            if ($result->isValid()) {
                $this->view->data = "done";
                $auth = Zend_Auth::getInstance();
                $storage = $auth->getStorage();
                $storage->write($authAdapter->getResultRowObject(array('email', 'id', 'name')));
                $this->redirect('/index');
            } else {
                $this->view->data = "Username or password is not correct";
            }
        }
    }

    public function logoutAction()
    {
        $auth =Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->redirect('index/');
    }

//    public function myOrdersAction()
//    {
//        $order_model = new Application_Model_Order();
//        
//        if(isset($_POST['serach'])){
//            $dateRang = array($_POST['from'],$_POST['to']);
//            $usersOrder = $order_model->getUserOrders(2,$dateRang);
//            if(count($usersOrder) > 0){
//                $this->view->order = $usersOrder;
//                $prod_id= array();
//                for ($i = 0; $i < count($usersOrder); $i++) {
//                    $prod_id[]= $usersOrder[$i]['order_id'];
//
//                }
//                $this->view->total = $order_model->orderTotalPrice($prod_id);
//                $this->view->product = $order_model->getUserProducOrders($prod_id);
//            }
//        }else{
//            $usersOrder = $order_model->getUserOrders(2);
//            if(count($usersOrder) > 0){
//                $this->view->order = $usersOrder;
//                $prod_id= array();
//                for ($i = 0; $i < count($usersOrder); $i++) {
//                    $prod_id[]= $usersOrder[$i]['order_id'];
//
//                }
//                $this->view->total = $order_model->orderTotalPrice($prod_id);
//                $this->view->product = $order_model->getUserProducOrders($prod_id);
//            }
//        }
//        
//        if(null !==($this->getRequest()->getParam('error'))){
//             $this->view->error = 'error in delete';
//        }
//        
//        
//    }
//    function deleteOrderAction() {
//        $order_model = new Application_Model_Order();
//   
//        $delete = $order_model->deleteOrder($this->getRequest()->getParam('id'));
//        
//        if($delete){
//            $this->_redirect('/index/my-orders');
//        }else{
//            $this->_redirect('/index/my-orders/error/error');
//        }
//    }
    
    

}











