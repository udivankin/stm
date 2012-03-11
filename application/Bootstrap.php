<?php


class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    // register globals set in application.ini
    public function _initConstants()
    {
	$hashsalt= $this->getOption('hashsalt');
	Zend_Registry::set('hashsalt', $hashsalt);
    }

}

