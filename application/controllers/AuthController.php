<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $this->_helper->redirector('login');
    }

    public function loginAction()
    {
        // action login

        if (Zend_Auth::getInstance()->hasIdentity()) {
            // redirect to homepeage if logged in 
            $this->_helper->redirector('index', 'Stories');
        }

        // pass login form to view
        $form = new Application_Form_Login();
        $this->view->form = $form;

        // if form is submitted via post request
        
        if ($this->getRequest()->isPost()) {
            
            // get form data
            $formData = $this->getRequest()->getPost();

            // validate fields
            if ($form->isValid($formData)) {
                
                // defining new Zend_Auth_Adapter_DbTable
                $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());

                // set fields to proceed auth
                $authAdapter->setTableName('users')
                            ->setIdentityColumn('username')
                            ->setCredentialColumn('password');

                // getting post variables
                $username = $this->getRequest()->getPost('username');
                $password = $this->getRequest()->getPost('password');

                // and passing to auth adapter
                $authAdapter->setIdentity($username)
                    ->setCredential($password);

                // getting new Zend_Auth instance
                $auth = Zend_Auth::getInstance();

                // trying to authenticate via submitted credentials
                $result = $auth->authenticate($authAdapter);

                // if we had luck with auth
                if ($result->isValid()) {
                    
                    // passing  user info to $identity
                    $identity = $authAdapter->getResultRowObject();

                    // user storage to $authStorage
                    $authStorage = $auth->getStorage();

                    // and storing $identity there
                    $authStorage->write($identity);

                    // using redirection helper to redirect to homepage
                    $this->_helper->redirector('index', 'Stories');
                    
                } else {
                    
                    $this->view->errMessage = 'Wrong user name or password';
                    
                }
            }
        }
    }


    public function logoutAction()
    {
        // action logout
        Zend_Auth::getInstance()->clearIdentity();

        // using redirection helper to redirect to homepage
        $this->_helper->redirector('login', 'Auth');
    }



}





