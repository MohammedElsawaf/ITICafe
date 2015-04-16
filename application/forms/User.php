<?php

class Application_Form_User extends Zend_Form {

    private $baseUrl;

    function __construct($baseUrl) {
        $this->baseUrl = $baseUrl;

        parent::__construct();
    }

    public function init() {
       
        $class = ['id' => 'myForm'];
        $this->addAttribs($class);
        $this->setEnctype("multipart/form-data");
        
        //usename
        $name = new Zend_Form_Element_Text("name");
        $name->setAttrib("class", "form-control");
        $name->setAttrib("id", "name");
        $name->setRequired();
        $name->addFilter(new Zend_Filter_StripTags());

        //Email
        $email = new Zend_Form_Element_Text("email");
        $email->setRequired();
        $email->setAttrib("id", "email");
        $email->addValidator(new Zend_Validate_Db_NoRecordExists(array("table"=>"users","field"=>"email")));
        $email->setAttrib("class", "form-control");
        $email->addFilter(new Zend_Filter_StripTags());
        $email->addValidator(new Zend_Validate_EmailAddress);

        //password
        $password = new Zend_Form_Element_Password("password");
        $password->setRequired();
        $password->setAttrib("class", "form-control");
        $password->setAttrib("id", "password");
        $password->addValidator(new Zend_Validate_StringLength(array('min' => 5, 'max' => 15)));

        // Confirm password
        $cpassword = new Zend_Form_Element_Password("cpassword");
        $cpassword->setRequired();
        $cpassword->setAttrib("id", "cpassword");
        $cpassword->setAttrib("class", "form-control");
        $cpassword->addValidator('Identical', false, array('token' => 'password'));

        //The Room Num.
        $room_num = new Zend_Form_Element_Text("room_no");
        
        $room_num->setRequired();
        $room_num->setAttrib("class", "form-control");
        $room_num->setAttrib("id", "room-num");

        //Ext
        $ext = new Zend_Form_Element_Text("ext");
        $ext->setAttrib("class", "form-control");
        $ext->setAttrib("id", "ext");
        //the profile image
        $image = new Zend_Form_Element_File("image");
        $image->setAttrib("id", "image");
        $image->setAttrib("class", "form-control");
        $image->addValidator('extension', TRUE, array('jpg', 'png', 'gif'));
        $image->setDestination(APPLICATION_PATH . '/../public/upload');


        $submit = new Zend_Form_Element_Submit("submit");

        $this->addElements(array($name, $email, $password, $cpassword, $room_num, $ext, $image,$submit));
    }

}
