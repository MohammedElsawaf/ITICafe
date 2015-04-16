<?php

class Application_Form_Product extends Zend_Form
{

    public function init()
    {
        $min_price=1.5;
        
        $this->setMethod('post');
        $product_id=new Zend_Form_Element_Hidden("product_id");
        $product_name = new Zend_Form_Element_Text("product_name");
        $product_name->setLabel("Product Name: ");
        $product_name->setRequired();
        $product_name->addFilter(new Zend_Filter_StripTags);
        $product_name->addFilter(new Zend_Filter_StringTrim);
        
        $price=new Zend_Form_Element_Text("price");
        $price->setLabel("Product Price: ");
        $price->setRequired();
        $price->addValidator(new Zend_Validate_Float);
        $price->addValidator(new Zend_Validate_GreaterThan($min_price));
        
        $product_image = new Zend_Form_Element_File('product_image');
        $product_image->setLabel('Upload an image:')->setRequired(true)
        ->setValueDisabled(true);
        // ensure only 1 file
        $product_image->addValidator('Count', false, 1);
        // only JPEG, PNG, and GIFs
        //$image->addValidator('Extension', false, 'jpg,png,gif');
        
        
        $avaliable = new Zend_Form_Element_Radio('avaliable');
        $avaliable->setLabel('Availbility: ')->addMultiOptions(array('avaliable' => 'Available',
                                    'unavailable'=> 'Not available'))->setSeparator('  ');
        $category_category_id=  new Zend_Form_Element_Select('category_category_id');
        $category_category_id->setLabel('Under Category: ');
        //->addMultiOptions(array(1=> 'Nescafee',
            //2=>'captchino', 3=>'tea', 4=>'milk')
        $submit = new Zend_Form_Element_Submit("Add This Product");
        $this->addElements(array($product_id,$product_name,$price,$product_image,$avaliable,$category_category_id,$submit));
    }


}

