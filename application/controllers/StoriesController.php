<?php

class StoriesController extends Zend_Controller_Action
{

    public function init()
    {
        // if authorised initializing necessary models
	if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->stories = new Application_Model_DbTable_Stories();
            $this->comments = new Application_Model_DbTable_Comments();
	    // current user auth data fo view
	    $this->view->userInfo = Zend_Auth::getInstance()->getStorage()->read();
	    // and for controller
	    $this->userInfo = Zend_Auth::getInstance()->getStorage()->read();
	    // init ajax context for specified actions
	    $ajaxContext = $this->_helper->getHelper('AjaxContext');
	    $ajaxContext->addActionContext('updateStoryStatus', 'json')
			->addActionContext('updateStoryRating', 'json')
			->addActionContext('deleteStory', 'json')
			->addActionContext('addComment', 'json')
			->addActionContext('deleteComment', 'json')	    
			->initContext();
        }
	// otherwise redirect to login page
        else $this->_helper->redirector('login','Auth');
    }

    public function indexAction()
    {
	// fetch all related stories into an one big array
	$result = $this->stories->fetchAll('author="'.$this->userInfo->username.'" or officer = "'.$this->userInfo->username.'"');
        foreach ($result as $res) {
            $storycomments = $this->comments->getCommentsByID($res['id']);
            $str[]=array('content'=>$res,'comments'=>$storycomments);
        }
        if (isset($str)) $this->view->stories = $str;
	$this->view->officers = $this->stories->getStoriesOfficerList();
    }

    public function addCommentAction()
    {
        // action body
	if ($this->getRequest()->isXmlHttpRequest()) { 
	    $commentText = false;
	    $storyID = false;
	    $intValidator = new Zend_Validate_Digits();
	    if ($intValidator->isValid($this->_getParam('storyID'))) {
		$storyID = $this->_getParam('storyID');
	    }
	    // TODO: XSS and REGEX in comment field
	    $regexValidator = new Zend_Validate_Regex(array('pattern' => '/^[а-яa-z0-9\.\,\:\#\(\)\{\}\[\]\_\-\+\&\?\!\@\"\'\=\;]/i'));
	    if ($regexValidator->isValid($this->_getParam('commentText'))) {
		$commentText = $this->_getParam('commentText');
	    }
	    if ($storyID && $commentText) {
		$this->comments->addComment($storyID, $this->userInfo->username, $commentText);
		$res['result']=1;
		$res['text']=$this->userInfo->username.' wrote: '.$commentText;
	    } else {
		$res['result']=0;
	    }
	    $this->_helper->json($res);
	} else { 
	    $this->_helper->redirector('error','Error'); 
	}
	
    }

    public function deleteCommentAction()
    {
        // action body
	if ($this->getRequest()->isXmlHttpRequest()) { 
	    $result = 0;
	    $intValidator = new Zend_Validate_Digits();
	    if ($intValidator->isValid($this->_getParam('commentID'))) {
		$this->comments->deleteComment($this->_getParam('commentID'));
		$result = 1;
	    }
	    $this->_helper->json(array('result'=>$result));
	} else { 
	    $this->_helper->redirector('error','Error'); 
	}
    }

    public function addStoryAction()
    {
  
	// form rendering 
	$form = new Application_Form_Story();
	
	if($this->getRequest()->isPost()){
            if($form->isValid($_POST)){
		$data = $form->getValues();
	        $this->stories->addStory($data['title'],$data['desc'],$this->userInfo->username,$data['officer']);
	    }
	    $this->_helper->redirector('index','Stories'); 
	}
	$this->view->myCustomTitle = 'Create story';
	$this->view->form = $form;

    }

    public function deleteStoryAction()
    {
	if ($this->getRequest()->isXmlHttpRequest()) {
	    $result = 0;
	    $intValidator = new Zend_Validate_Digits();
	    if ($intValidator->isValid($this->_getParam('storyID'))) {
		$this->stories->deleteStory($this->_getParam('storyID'));
		$result = 1;
	    }
	    $this->_helper->json(array('result'=>$result));
	} else { 
	    $this->_helper->redirector('error','Error'); 
	}
    }

    public function updateStoryAction()
    {
	// form rendering 
	$form = new Application_Form_Story();
	
	if($this->getRequest()->isPost()){
            if($form->isValid($_POST)){
		$data = $form->getValues();
	        $this->stories->addStory($data['title'],$data['desc'],$this->userInfo->username,$data['officer']);
	    }
	    $this->_helper->redirector('index','Stories'); 
	}
	$this->view->myCustomTitle = 'Create story';
	$this->view->form = $form;
    }

    public function updateStoryStatusAction()
    {
        // action body
	if ($this->getRequest()->isXmlHttpRequest()) {
	    $result = 0;
	    $intValidator = new Zend_Validate_Digits();
	    if ($intValidator->isValid($this->_getParam('storyID'))) {
		$storyID = $this->_getParam('storyID');
	    }
	    if ($intValidator->isValid($this->_getParam('storyStatus'))) {
		$storyStatus = $this->_getParam('storyStatus');
	    }	    
	    if ($storyID && $storyStatus) {
		$this->stories->updateStoryStatus($storyID,$storyStatus);
	    	$result = 1;
	    }	 
	    $this->_helper->json(array('result'=>$result));
	} else { 
	    $this->_helper->redirector('error','Error'); 
	}
    }

    public function setStoryRatingAction()
    {
	if ($this->getRequest()->isXmlHttpRequest()) {
	    $result = 0;
	    $intValidator = new Zend_Validate_Digits();
	    if ($intValidator->isValid($this->_getParam('storyID'))) {
		$storyID = $this->_getParam('storyID');
	    }
	    if ($intValidator->isValid($this->_getParam('storyRating'))) {
		$storyRating = $this->_getParam('storyRating');
	    }	    
	    if ($storyID && $storyRating) {
		$this->stories->setStoryRating($storyID,$storyRating);
	    	$result = 1;
	    }	 
	    $this->_helper->json(array('result'=>$result));
	} else { 
	    $this->_helper->redirector('error','Error'); 
	}
    }


}









