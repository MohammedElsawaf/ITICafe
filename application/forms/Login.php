<?php

class Application_Form_Login extends Zend_Form{

    private $baseUrl;
            
    function __construct($baseUrl) {
        $this->baseUrl = $baseUrl;

        parent::__construct();
    }

    public function init() {
        $email = new Zend_Form_Element_Text("email");
        $email->setRequired();
        $email->setAttrib("class", "form-control input-lg");
        $email->setAttrib('placeholder', 'Enter Your Email Address');
        $email->addFilter(new Zend_Filter_StripTags());
        
        $password = new Zend_Form_Element_Password("password");
        $password->setRequired();
        $password->setAttrib("class", "form-control input-lg");
        $password->setAttrib('placeholder', 'Enter Your Password');
        $password->addValidator(new Zend_Validate_StringLength(array('min' => 5, 'max' => 15)));
        $submit = new Zend_Form_Element_Submit("submit");
        
        $this->addElements(array($email, $password, $submit));
    }
}

