<?php

// TODO: ADD STORIES VIA ZEND FORMS & AJAX (if possible)
// TODO: EDIT STORIES
// TODO: UPDATING STATUS W/LOGIC VIA AJAX
// TODO: STORY ID HIGHLIGHTING (maybe like #tag in twitter)
// TODO: PHPUNIT TESTING


class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    // register globals set in application.ini
    public function _initConstants()
    {
	$hashsalt= $this->getOption('hashsalt');
	Zend_Registry::set('hashsalt', $hashsalt);
    }

}

