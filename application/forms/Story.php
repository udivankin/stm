<?php

class Application_Form_Story extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
	$this->setName('Story editor');
	
	$id = new Zend_Form_Element_Hidden('id');
	$id->addFilter('Int');
	
	$isEmptyMessage = 'This field is required';
	
	$title = new Zend_Form_Element_Text('title');
	$title->setLabel('Title:')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => $isEmptyMessage)));
	
	$desc = new Zend_Form_Element_Textarea('desc');
        $desc->setLabel('Description:')
            ->setRequired(true)
            ->setAttrib('Rows', '5')
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
    	    ->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => $isEmptyMessage)));	
	
	$users = new Application_Model_DbTable_Users();
        $usersArr = $users->fetchAll();
	
	$officer = new Zend_Form_Element_Select('officer');
        $officer->setLabel('Officer:')
            ->setRequired(false)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
	    ->addValidator('Alnum')
            ->addMultiOption(0,' please choose officer');
	
        foreach ($usersArr as $user) {
            $officer->addMultiOption($user->username,$user->username);
        }
	
	$submit = new Zend_Form_Element_Submit('Submit');
        $submit->setAttrib('id', 'addStorySubmitBtn');

        // adding created elements to form
        $this->addElements(array($id, $title, $desc, $officer, $submit));
	
    }


}

