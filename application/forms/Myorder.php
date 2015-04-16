<?php

class Application_Form_Myorder extends Zend_Form
{

    public function init()
    {

 
        $datefrom=new Zend_Form_Element_Text("datefrom"); 
        $datefrom->setAttrib("id","datefrom");
        $datefrom->setLabel("Data From :");
       
       
       $dateto=new Zend_Form_Element_Text("dateto");
      $dateto->setAttrib("id", "dateto");
              $dateto->setLabel("Data To :");
 
       $this->addElements(array($datefrom,$dateto));
        
    }


}

