<?php

class Application_Form_Category extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $category_id=new Zend_Form_Element_Hidden("category_id");
        $category_name = new Zend_Form_Element_Text("category_name");
        $category_name->setLabel("Category Name: ");
        $category_name->setRequired();
        $category_name->addFilter(new Zend_Filter_StripTags);
        $category_name->addFilter(new Zend_Filter_StringTrim);

        $submit = new Zend_Form_Element_Submit("Add");
        $reset = new Zend_Form_Element_Submit("Reset");
        $this->addElements(array($category_id,$category_name,$submit,$reset));
    }

    


}

