<?php

class AdminController extends Zend_Controller_Action {

    public function init() {
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity() && $this->_request->getActionName() !== 'login') {
            $this->redirect('admin/login');
        } else {
            //check if he is admin or not
            $this->_helper->layout->setLayout('admin');
        }
    }

    public function indexAction() {
        
        $order_model = new Application_Model_Order();
        
        $this->view->product = $order_model->getAllProductsOrder();
        $this->view->orders = $order_model->getAllOrders();
    }

    public function loginAction() {
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
                $this->redirect('admin/index');
            } else {
                $this->view->data = "You Have Entered Wrong Username Or Not";
            }
        }
    }

    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->redirect('index/index/');
    }

    public function productsAction() {
    }

    
    
   public function addAction()
    {
        $form_product = new Application_Form_Product();
        $category_model=new Application_Model_Category();
        $category_list=$category_model->listCategory();
        
        for($i=0;$i<count($category_model->listCategory());$i++)
        {
            $form_product->getElement('category_category_id')->addMultiOptions(array(
            $category_model->listCategory()[$i]["category_id"] => 
            $category_model->listCategory()[$i]["category_name"]
            ));
        }
        $this->view->form_product = $form_product;
       
        if($this->getRequest()->isPost())
        {
          if($form_product->isValid($this->getRequest()->getParams()))
          {
            echo $form_product->getElement('product_image')->getValue(); 
            $ext=end(explode('.', $form_product->getElement('product_image')->getValue()));
            $path=APPLICATION_PATH.'/../public/upload/'.rand(0, 123456789).$ext;
            $form_product->getElement('product_image')->addFilter('Rename',array('target'=>$path,'overwrite'=>true));
            $form_product->getElement('product_image')->receive();
            $data_product=$form_product->getValues();
            $product_model=new Application_Model_Product();
            if($product_model->addProduct($data_product))
            {
                $this->redirect("admin/list");
            }
            else
            {
                echo "can not add product";
            }
              
          }
          else
          {
              echo "not valid form";
          }
            
        }
    }

    public function listAction()
    {
       $product_model=new Application_Model_Product();
       $this->view->products=$product_model->listProduct();
    }

    public function deleteAction()
    {
        $id=$this->getRequest()->getParam("id");
        if(isset($id))
        {
            $product_model=new Application_Model_Product();
            $product_model->deleteProduct($id);
            $this->redirect("admin/list");
        }
        
    }

    public function editAction()
    {
       $id = $this->getRequest()->getParam('id');
        if(isset($id))
        {
           $product_model=new Application_Model_Product();
           
           $form_product = new Application_Form_Product();
           $category_model=new Application_Model_Category();
        $category_list=$category_model->listCategory();
        
        for($i=0;$i<count($category_model->listCategory());$i++)
        {
            $form_product->getElement('category_category_id')->addMultiOptions(array(
            $category_model->listCategory()[$i]["category_id"] => 
            $category_model->listCategory()[$i]["category_name"]
            ));
        }
           $product_info = $product_model->getProductById($id);
         
           if(!empty($product_info))
           {
               $form_product->populate($product_info[0]);
               
               $this->view->form_product = $form_product;
               $this->render('add');
           }
           
        
        if($this->getRequest()->isPost())
        {
          if($form_product->isValid($this->getRequest()->getParams()))
          {
              $product_info=$form_product->getValues();
              var_dump($product_info);
                
          }
            if($product_model->editProduct($product_info))
                {$this->redirect("admin/list");}
              else
                  echo "can`t edit product";
          }
        } 


        }
        
        
        
        
    public function indexcategoryAction()
    {
        $category_model=new Application_Model_Category();
        for($i=0;$i<count($category_model->listCategory());$i++)
        {
            echo $category_model->listCategory()[$i]["category_id"];
            echo $category_model->listCategory()[$i]["category_name"];
            echo "<br>";
        }
        
    }
    public function addcategoryAction()
    {
        $form_category = new Application_Form_Category;
        $this->view->form_category = $form_category;
        
        if($this->getRequest()->isPost())
        {
          if($form_category->isValid($this->getRequest()->getParams()))
          {
              
              
            if(!empty($this->getRequest()->getParams()["Add"]))
            {
                 $data_category=$form_category->getValues(); 
                 var_dump($data_category);
                 $category_model=new Application_Model_Category();
                 if($category_model->addCategory($data_category))
                {
                    $this->redirect("admin/listcategory");
                }
                else
                {
                    echo "can not add category";
                }
            }
            if(!empty($this->getRequest()->getParams()["Reset"]=="Reset"))
            {
                $form_category = new Application_Form_Category;
                $this->view->form_category = $form_category;
            }
            
          }
          else
          {
              echo "not valid form";
          }
        }   
        
    }

    public function listcategoryAction()
    {
       $category_model=new Application_Model_Category();
       $this->view->categorys=$category_model->listCategory();
    }

    public function deletecategoryAction()
    {
        $id=$this->getRequest()->getParam("id");
        if(isset($id))
        {
            $category_model=new Application_Model_Category();
            $category_model->deleteCategory($id);
            $this->redirect("admin/listcategory");
        }
        
    }

    public function editcategoryAction()
    {
       $id = $this->getRequest()->getParam('id');
        if(isset($id))
        {
           $category_model=new Application_Model_Category();
           $form_category = new Application_Form_Category;
           $category_info = $category_model->getCategoryById($id);
           //var_dump($product_info[0]) ;
           if(!empty($category_info))
           {
               $form_category->populate($category_info[0]);
               $this->view->form_category = $form_category;
               $this->render('add');
           
           }
        
        if($this->getRequest()->isPost())
        {
          if($form_category->isValid($this->getRequest()->getParams()))
          {
              if(!empty($this->getRequest()->getParams()["Add"]))
            {
              $category_info=$form_category->getValues();
              var_dump($category_info);
               
          
            if($category_model->editCategory($category_info))
                {$this->redirect("admin/listcategory");}
              else
                  echo "can`t edit Category";
            }
            if(!empty($this->getRequest()->getParams()["Reset"]=="Reset"))
            {
                $form_category = new Application_Form_Category;
                $this->view->form_category = $form_category;
                $this->render('add');
            }
            
          }
        } 
           }

        }
        


    public function indexuserAction() {
        $user_model = new Application_Model_Users();
        $this->view->users = $user_model->listUsers();
    }

    public function adduserAction() {
        $form = new Application_Form_User($this->view->baseUrl());
        $this->view->action = "Add User";
        $this->view->js = "AddUser";
        $this->view->form = $form;

        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getParams())) {
            $user_model = new Application_Model_Users();
            $data = $form->getValues();
            var_dump($form);
            if($data['image'] === NULL){
                $data['image'] = "profile.jpg";
            }
            unset($data['cpassword']);
            $data['password'] = md5($data['password']);
            if ($user_model->addUser($data)) {
                $upload = new Zend_File_Transfer_Adapter_Http();
                $upload->receive();
                $this->redirect('admin/indexuser');
            }
        }
    }

    public function deleteuserAction() {
        $user_model = new Application_Model_Users();
        $user_model->deleteUser($this->getRequest()->getParam("id"));
        $this->redirect('/admin/indexuser');
    }
    
    public function edituserAction() {
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

    public function ordersAction() {
        
    }

    public function addOrderAction() {
        $user_model = new Application_Model_Users();
        $this->view->alluser = $user_model->listUsers();
        $users = new Application_Model_Users;

    }

    public function editOrderAction() {
        // action body
    }

    public function deleteOrderAction() {
        // action body
    }


 public function checksAction() {
        $order_model = new Application_Model_Order();
        $user_model = new Application_Model_Users();
        if (isset($_POST['serach'])) {
            $dateRang = array($_POST['from'], $_POST['to']);
            $usersOrder = $order_model->getUserOrders($_POST['user'], $dateRang);
            if (count($usersOrder) > 0) { 
                $this->view->order = $usersOrder;
                $prod_id = array();
                $order_id = array();
                for ($i = 0; $i < count($usersOrder); $i++) {
                    $prod_id[] = $usersOrder[$i]['order_id'];
                    
                }
                $this->view->total = $order_model->orderTotalPrice($prod_id);
                $this->view->product = $order_model->getUserProducOrders($prod_id);
               
                $this->view->users = $order_model->userAmount($prod_id);
                
            }
        } else {
            $usersOrder = $order_model->getUserOrders(0);
            if (count($usersOrder) > 0) {
                $this->view->order = $usersOrder;
                $prod_id = array();
                for ($i = 0; $i < count($usersOrder); $i++) {
                    $prod_id[] = $usersOrder[$i]['order_id'];
                }
                $this->view->total = $order_model->orderTotalPrice($prod_id);
                $this->view->product = $order_model->getUserProducOrders();
               
                $this->view->users = $order_model->userAmount($prod_id);
               
            }
        }
        $this->view->alluser = $user_model->listUsers();
        if (null !== ($this->getRequest()->getParam('error'))) {
            $this->view->error = 'error in delete';
        }
        $this->_helper->viewRenderer('admin/checks', null, true);
    }

    public function addCheckAction() {
        // action body
    }

    public function editCheckAction() {
        // action body
    }

    public function deleteCheckAction() {
        // action body
    }

}
