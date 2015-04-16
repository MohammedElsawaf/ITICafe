<?php

class MyorderController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function listmyyorderAction()
    {
        $dateformx = new Application_Form_Myorder();
        $this->view->myform =$dateformx;
        $sdate = $this->getRequest()->getPost();
        if (isset($sdate['datefrom']) && isset($sdate['dateto'])) {
            $this->_helper->viewRenderer->setNoRender();

            $model = new Application_Model_Order();

            echo json_encode($model->getOrders($sdate['datefrom'], $sdate['dateto'], 3)); //$id

            exit();
        } elseif (isset($sdate['orderId']) && isset($sdate['prodorderId'])) {
            $this->_helper->viewRenderer->setNoRender();

            $model = new Application_Model_Order();
            echo json_encode($model->cancelOrder($sdate['orderId']));

            //echo json_encode($orderobj->deleteOrders($sdate['orderId'], $sdate['prodorderId'])); //$id

            exit();
        }  elseif(isset($sdate['date']) && isset($sdate['user_id'])){
            $this->_helper->viewRenderer->setNoRender();
            $date=$sdate['date'];
            $user_id=$sdate['user_id'];
            $model = new Application_Model_Order();
            echo json_encode($model->getProductOrder($date,$user_id));
            exit();
        }
    } 
        
    
    

    public function ajaxactionAction()
    {
         
    }


}









