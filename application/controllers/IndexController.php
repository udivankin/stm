<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index','Stories');
        }
        else {
            $this->_helper->redirector('login','Auth');
        }
        
    }


}

