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

                // getting post variables
                $username = $this->getRequest()->getPost('username');
                $password = $this->getRequest()->getPost('password');
		
		// set fields to proceed auth
                $authAdapter->setTableName('users')
                            ->setIdentityColumn('username')
                            ->setCredentialColumn('password');


		$salt = Zend_Registry::get('hashsalt');

                // set auth type		
                $authAdapter->setIdentity($username)
                    ->setCredential(md5($password.$salt));

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

    public function signupAction()
    {
        // action body
	// TODO : check if signed in
	
        $form = new Application_Form_Signup();
        $this->view->form=$form;
	
	// getting a model instance
	$users = new Application_Model_DbTable_Users();
	
	// if form is submitted
        if($this->getRequest()->isPost()){
            if($form->isValid($_POST)){
                $data = $form->getValues();
		// check if passwords match
                if($data['password'] != $data['confirmPassword']){
                    $this->view->errorMessage = "Password and confirm password don't match.";
                    return;
                }
		// check if already exists
                if($users->checkUnique($data['username'])){
                    $this->view->errorMessage = "Name already taken. Please choose another one.";
                    return;
                }
		$salt = Zend_Registry::get('hashsalt');
		// replace password taken from form by salted hash
		$data['password'] = md5($data['password'].$salt);
		// unset confirm password
                unset($data['confirmPassword']);
		// insert data to database TODO: delete role column from users table
                $users->insert($data);
                $this->_redirect('auth/login');
            }
        }
	
	
    }
    


}







