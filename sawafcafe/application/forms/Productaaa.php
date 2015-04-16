<?php

class Application_Form_Product extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $class = ['id' => 'myForm'];
        $this->addAttribs($class);
        $this->setEnctype("multipart/form-data");
        //Name
        $name = new Zend_Form_Element_Text("product_name");
        $name->setAttrib("class", "form-control");
        $name->setRequired();
        $name->addFilter(new Zend_Filter_StripTags());
        
        //Profile Image
        $image = new Zend_Form_Element_File("product_image");
        $image->setRequired();
        $image->setAttrib("class", "form-control");
        
        //addUser
        $submit = new Zend_Form_Element_Submit("submit");

        $this->addElements(array($name, $image,$submit));
    }


}

