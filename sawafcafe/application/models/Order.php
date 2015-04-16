<?php

class Application_Model_Order extends Zend_Db_Table_Abstract
{

    protected $_name = 'orders';
    
    
    function getOrders($datefrom, $dateto, $id) {

        $select = $this->select()
                ->from(array('o' => 'orders'), //t1
                        array('date', 'users_user_id', 'status', 'order_id','sumq'=>'SUM(`quantity`)'))  //select cols from table
                ->join(array('r' => 'product_has_orders'), //t2
                        'o.order_id = r.orders_order_id')
                ->where('o.date >= ?', $datefrom)
                ->where('o.status!= ?', 'cancel')
                ->where('o.date <= ?', $dateto)
                
                ->where('o.users_user_id = ?', $id)
                ->group('o.date');

        $select->setIntegrityCheck(false);
        $row = $this->fetchAll($select)->toArray();
        return $row;
    }

    function cancelOrder($id_orders) {
         return $this->update(array('status' => 'cancel'), "order_id =$id_orders");
        
    }
    
     function getProductOrder($date,$U_id){
        $select = $this->select();
        $select->from(array('o' => $this->_name), array())
        ->join(array('od' => 'product_has_orders'), 'o.order_id=od.orders_order_id', array("quantity"))
        ->join(array('p' => 'product'), 'p.product_id = od.product_product_id', array("product_name","product_image","price"))
        ->where("date= ?" , $date)
        ->where("users_user_id= ?" ,$U_id)->setIntegrityCheck(false);
        
        return $this->fetchAll($select)->toArray();
    }

    function addOrder($data)
    {
        $this->getAdapter()->beginTransaction();
        $this->insert($data);
        $order_id = $this->getAdapter()->lastInsertId();
        $this->_name = 'product_has_orders';
        $order_product['orders_order_id'] = $order_id;
        foreach ($_SESSION['fatora'] as $key => $value) {
            $order_product['product_product_id'] = $key;
            $order_product['quantity'] = $value['qnty'];
            $this->insert($order_product);
        }
        $this->getAdapter()->commit();
        $this->_name = 'orders';
        return 1;
    }
   public function editOrder($data, $id) {
       
       if(isset($data['status'])){
           if($data['status'] === 'out for delivery'){
                $q = 'CREATE EVENT myevent
                        ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 MINUTE
                        DO
                        update orders SET `status`="done" where status="out for delivery" and order_id="'.$id.'" ;';
               
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->query($q);
           }
       }
        return $this->update($data, 'order_id=' . $id);
    }
    function getLastOrderDate()
    {
        $select = $this->select()
            ->limit(1)
            ->order('date desc');
        return array_shift($this->fetchAll($select)->toArray());
    }

    function getLastOrder($id, $limit = 1)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $lastOrder = $db->select()
            ->from('orders')
            ->where('users_user_id = ?', $id)
            ->limit($limit)
            ->order('date desc');
        
        $results = $lastOrder->query()->fetchAll();
        if ($results) {
            $lastOrderQuery = $db->select('')
                ->from('product_has_orders', array(
                'product_product_id'
            ))
                ->where('orders_order_id = ?', $results[0]['order_id']);
            
            $productOfLastOrder = $lastOrderQuery->query()->fetchAll();
            // return $productOfLastOrder;
            $prod_id = array();
            for ($i = 0; $i < count($productOfLastOrder); $i ++) {
                $prod_id[] = $productOfLastOrder[$i]['product_product_id'];
                ;
            }
            
            $lastOrderQuery = $db->select()
                ->from('product', array(
                'product_name',
                'product_image'
            ))
                ->where('product_id in (?)', $prod_id);
            
            $productOfLastOrder = $lastOrderQuery->query()->fetchAll();
            
            return $productOfLastOrder;
        } else {
            return false;
        }
    }

    function getUserOrders($user_id, $dateRange = '')
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        if (is_array($dateRange)) {
            if ($dateRange[0] != $dateRange[1]) {
                if ($user_id == 0) {
                    $userOrder = $db->select()
                        ->from('orders', array(
                        'order_id',
                        'date',
                        'status'
                    ))->order('date desc')
                        ->where('date >= ?', $dateRange[0])
                        ->where('date <= ? ', $dateRange[1]);
                } else {
                    $userOrder = $db->select()
                        ->from('orders', array(
                        'order_id',
                        'date',
                        'status'
                    ))->order('date desc')
                        ->where('users_user_id = ? ', $user_id)
                        ->where('date >= ?', $dateRange[0])
                        ->where('date <= ? ', $dateRange[1]);
                }
            } else {
                if ($user_id == 0) {
                    $userOrder = $db->select()
                        ->from('orders', array(
                        'order_id',
                        'date',
                        'status'
                    ))
                        ->where('date like ?', $dateRange[0] . "%");
                } else {
                    $userOrder = $db->select()
                        ->from('orders', array(
                        'order_id',
                        'date',
                        'status'
                    ))->order('date desc')
                        ->where('users_user_id = ? ', $user_id)
                        ->where('date like ?', $dateRange[0] . "%");
                }
            }
        } else {
            if ($user_id == 0) {
                $userOrder = $db->select()->from('orders', array(
                    'order_id',
                    'date',
                    'status'
                ))->order('date desc');
            } else {
                $userOrder = $db->select()
                    ->from('orders', array(
                    'order_id',
                    'date',
                    'status'
                ))->order('date desc')
                    ->where('users_user_id = ?', $user_id);
            }
        }
        
        $userProductOrder = $userOrder->query()->fetchAll();
        
        return $userProductOrder;
    }

    function getUserProducOrders($order_id = 0)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        if ($order_id == 0) {
            $userOrder = $db->select()
                ->from('product_has_orders')
                ->joinInner('product', 'product_product_id = product_id')
                ->joinInner('orders', 'orders_order_id = order_id');
        } else {
            $userOrder = $db->select()
                ->from('product_has_orders')
                ->joinInner('product', 'product_product_id = product_id')
                ->joinInner('orders', 'orders_order_id = order_id')
                ->where('orders_order_id in (?)', $order_id);
        }
        
        $userProductOrder = $userOrder->query()->fetchAll();
        return $userProductOrder;
    }

    function orderTotalPrice($order_id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $TotalPrice = $db->select()
            ->from(('product_has_orders'), array(
            "amount" => "sum(price*quantity)"
        ))
            ->joinInner('product', 'product_product_id = product_id')
            ->where('orders_order_id in (?)', $order_id)
            ->group(array(
            "orders_order_id"
        ));
        //die($TotalPrice);
        $userProductOrder = $TotalPrice->query()->fetchAll();
        return $userProductOrder;
    }

    function deleteOrder($id)
    {
        return $this->delete("status = 'processing' and order_id=$id");
    }

    function getAllOrders($status= 'all',$order)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        if($status === 'all'){
            $getUserOrders = $db->select()
            ->from('orders')
            ->order('date desc')
            ->joinInner('users', 'users_user_id = user_id');
        }else{
            $getUserOrders = $db->select()
            ->from('orders')
            ->where("status = '$status'")
            ->order('date desc')
            ->joinInner('users', 'users_user_id = user_id');
        }
        
        return $getUserOrders->query()->fetchAll();
    }

    function getAllProductsOrder()
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $userOrder = $db->select()
            ->from('product_has_orders')
            ->joinInner('product', 'product_product_id = product_id');
        return $userOrder->query()->fetchAll();
    }

    function usersHaveOrders($prod_id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $users = $db->select()
            ->from('orders', array())
            ->joinInner('users', 'users_user_id = user_id')
            ->where('order_id in (?)',$prod_id)
            ->distinct();
        return $users->query()->fetchAll();
    }
    
    function userAmount($prod_id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
         
         
          $TotalPrice = $db->select()
            ->from(('product_has_orders'), array(
            "amount" => "sum(price*quantity)"
        ))
            ->joinInner('product', 'product_product_id = product_id',array())
            ->joinInner('orders', 'orders_order_id = order_id',array('users_user_id as user_id'))
            ->joinInner('users', 'users_user_id = user_id',array('name'))
            ->where('orders_order_id in (?)', $prod_id)
            ->group(array(
            "users_user_id"
        ));
         
        return $TotalPrice->query()->fetchAll();
    }
}
