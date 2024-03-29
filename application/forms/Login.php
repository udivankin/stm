<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        // define form name
        $this->setName('login');
        
        // error message
        $isEmptyMessage = 'This field is required!';
        
        // instantiating an element and passing to the form object:
        $username = new Zend_Form_Element_Text('username');
        
        // defining label, validators, filter tags and spaces
        $username->setLabel('Login or email:')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addFilter('StringToLower')
            ->addValidator('regex', false, array('/^[a-z0-9\@\_\-\.]/'))
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage,))
            );
        
       // instantiating an element and passing to the form object 
        $password = new Zend_Form_Element_Password('password');
        
        // defining label, validators, filter tags and spaces
        $password->setLabel('Password:')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('alnum')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );
        
        // creating submit button
        $submit = new Zend_Form_Element_Submit(array( 
            'name' => 'login', 
            'content' => 'Login', 
            'class' => 'btn-primary' 
	));
        $submit->setLabel('Submit');
	
        // adding elements to the form
	
        $this->addElements(array($username, $password, $submit));
        
        // defining form method
        $this->setMethod('post');

    }


}

