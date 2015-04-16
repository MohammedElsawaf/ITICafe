<?php
class MakeorderController extends Zend_Controller_Action
{
    public function init()
    {
//        unset($_SESSION);
     //  unset($_SESSION['order']);
    }

    public function indexAction()
    {
        $product_model = new Application_Model_Makeorder();
        $this->view->availableproduct = $product_model->listAvailableProavailableducts();
    }
    public function madeAction()
    {
        
//     `o_id`, `state`, `U_id`, `P_id`, `amount`, `Price` FROM `order`
         $total = 0;
        if ($this->getRequest()->getParam("product_id")) {
            $product_model = new Application_Model_Makeorder();
            $productid = $this->getRequest()->getParam("product_id");
            $flag = 0;
           //order
            //echo $productid;
            if (isset($_SESSION['order'])) {
                for ($i = 0; $i < count($_SESSION['order']); $i++) {
                    if ($_SESSION['order'][$i]['product_id'] == $productid) {
                        $_SESSION['order'][$i]['amount'] ++;
                        $_SESSION['order'][$i]['price'] = $_SESSION['order'][$i]['price'] * $_SESSION['orders'][$i]['amount'];
                        $flag = 1;
                    }
                }
                if ($flag == 0) {
                    unset($_SESSION['error']);
                    $data['product_id'] = $productid;
                    $prodctdata = $product_model->getProductById($productid);
//                    $_SESSION['productdata'] = $prodctdata;
                    $data['amount'] = 1;
                    $data['product_name'] = $prodctdata[0]['product_name'];
                    $data['price'] = $prodctdata[0]['price'];
                    $data['price'] = $data['price'] *$data['amount'];
                    array_push($_SESSION['order'], $data);
                } else {
                    unset($_SESSION['error']);

                    //$_SESSION['error']="you add this product";  
                }
            } else {
                $data[0]['product_id'] = $productid;
                $prodctdata= $product_model->getProductById($productid);
//                $_SESSION['productdata'] = $prodctdata;
                $data[0]['amount'] = 1;
                $data[0]['product_name'] = $prodctdata[0]['product_name'];
                $data[0]['price'] = $prodctdata[0]['price'];
                $data[0]['price'] = $prodctdata[0]['price'] * $data[0]['amount'];
                $_SESSION['order'] = $data;
                unset($_SESSION['error']);
            }
        }
        echo '<div id=order>';
        if (isset($_SESSION['order'])) {
//            echo'<pre>';
//            print_r($_SESSION['order']);
//            echo'<pre>';
            for ($i = 0; $i < count($_SESSION['order']); $i++) {
                $order = array_shift($_SESSION['order']);
                echo"<div>";
                echo $order['product_name'];
                echo "<input type='number' style=' width:30px;' value='" . $order['amount'] . "'>";
                echo "<button class='incre' prodid='" . $order['product_id'] . "' >+</button>";
                echo "<button class='decre' prodid='" . $order['product_id'] . "'>-</button>";
                echo "EGP " . $order['price'];
                echo "<button class='del' prodid='" . $order['product_id'] . "'>X</button>";
                echo"</div>";
                $total = $total + $order['price'];
                $_SESSION['order'][] = $order;
            }
            $_SESSION['totalprice'] = $total;
            echo "</div><hr>";
            echo "<label>Total Price :</label>  <label> " . $total . "</label>";
        }
        exit();
    }
    
      public function updateAction()
    {

        if ($this->getRequest()->getParam("incid")) {
            $updateid = $this->getRequest()->getParam("incid");
            if (isset($_SESSION['order'])) {
                for ($i = 0; $i < count($_SESSION['order']); $i++) {
                    if ($_SESSION['order'][$i]['product_id'] == $updateid) {
                         $price = $_SESSION['order'][$i]['price'] / $_SESSION['order'][$i]['amount'];
                        $_SESSION['order'][$i]['amount'] ++;
                       
                        $_SESSION['order'][$i]['price'] = $price+ $_SESSION['order'][$i]['price'];
                    }
                }
            }
        }
        if ($this->getRequest()->getParam("decid")) {
            $updateid = $this->getRequest()->getParam("decid");
            if (isset($_SESSION['order'])) {
                for ($i = 0; $i < count($_SESSION['order']); $i++) {
                    if ($_SESSION['order'][$i]['product_id'] == $updateid) {
                           
                            $price = $_SESSION['order'][$i]['price'] / $_SESSION['order'][$i]['amount'];
                        $_SESSION['order'][$i]['amount'] --;
                        if ($_SESSION['order'][$i]['amount'] == 0) {
                            $_SESSION['order'][$i]['amount'] = 1;
                        }
                        $_SESSION['order'][$i]['price'] = $_SESSION['order'][$i]['amount']*$price;
                    }
                }
            }
        }
        if ($this->getRequest()->getParam("delid")) {

            $updateid = $this->getRequest()->getParam("delid");
            if (isset($_SESSION['order'])) {
                for ($i = 0; $i < count($_SESSION['order']); $i++) {
                    if ($_SESSION['order'][$i]['product_id'] == $updateid) {
                        unset($_SESSION['order'][$i]);
                    }
                }
            }
        }
//        print_r($_SESSION["orders"]);
//        echo json_encode($_SESSION["orders"]);

        echo '<div id=order>';
        $totalprice = 0;
        for ($i = 0; $i < count($_SESSION['order']); $i++) {
            $order = array_shift($_SESSION['order']);
            echo"<div>";
            echo $order['product_name'];
            echo "<input type='number' style=' width:30px;' value='" . $order['amount'] . "'>";
            echo "<button class='incre' prodid='" . $order['product_id'] . "' >+</button>";
            echo "<button class='decre' prodid='" . $order['product_id'] . "'>-</button>";
            echo "EGP " . $order['price'];
            echo "<button class='del' prodid='" . $order['product_id'] . "'>X</button>";
            echo"</div>";
            $totalprice = $totalprice + $order['price'];
            $_SESSION['order'][] = $order;
        }
        $_SESSION['price'] = $totalprice;
        echo "</div><hr>";
        
        echo "<label>Total Price :</label>  <label> " . $totalprice . "</label>";
        exit();
    }
    public function confirmAction()
    {
       
        $users_user_id=6;
        $status='process';
        $data = array();
        $data=['users_user_id'=>$users_user_id,'status'=>$status];
        if ($this->getRequest()->isPost()){
        
         $order_model = new Application_Model_Orders();
         $order_model->addorder($data);
          unset($_SESSION['order']);
          $this->render('index');
//            
            $this->redirect('Makeorder/');
//            $this->view->roomid=$this->getRequest()->getParam("roomid");
       }
      
    }


}



