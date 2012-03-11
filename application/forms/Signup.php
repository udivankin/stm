<?php

class Application_Form_Signup extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
                
         // define form name
        $this->setName('signup');
	
	// error message
        $isEmptyMessage = 'This field is required!';

        // defining label, validators, filter tags and spaces	
	$username = $this->createElement('text','username');
        $username->setLabel('Login: *')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('alnum')
		->addValidator('NotEmpty', true,
		    array('messages' => array('isEmpty' => $isEmptyMessage))
		);

        // defining label, validators, filter tags and spaces	
	$email = $this->createElement('text','email');
        $email->setLabel('E-mail: *')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('EmailAddress');
	
        // defining label, validators, filter tags and spaces	
        $password = $this->createElement('password','password');
        $password->setLabel('Password: *')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('alnum')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );
                
        // defining label, validators, filter tags and spaces	
        $confirmPassword = $this->createElement('password','confirmPassword');
        $confirmPassword->setLabel('Confirm Password: *')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('alnum')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );
                
	// creating submit button
        $submit = $this->createElement('submit','register');
        $submit->setLabel('Submit')
                ->setIgnore(true);

	// adding elements to the form               
        $this->addElements(array($username,$email,$password,$confirmPassword,$submit));
	
	// defining form method
        $this->setMethod('post');
	
    }


}

