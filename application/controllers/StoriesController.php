<?php

class StoriesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
	if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->stories = new Application_Model_DbTable_Stories();
	    $this->view->userInfo = Zend_Auth::getInstance()->getStorage()->read();
        }
        else {
            $this->_helper->redirector('login','Auth');
        }
    }

    public function indexAction()
    {
        // action body
	
	$result = $this->stories->fetchAll();
	$this->view->stories = $result;
	
    }


}

