<?php

// TODO: EDIT STORIES
// TODO: STORY ID HIGHLIGHTING (maybe like #tag in twitter)
// TODO: SQL security - GET only related stories, UPDATE/DELETE only own STORIES, DELETE ONLY OWN COMMENTS
// TODO: IF REJECTED USER SHOULD BE ABLE TO MAKE STORY "STARTED"
// TODO: PHPUNIT TESTING

// TODO: ADD STORIES
// DONE: Set disabled status to delete and edit buttons if user is not owner
// DONE: STORY RATING (ensure that shown only for Author, only when story is Finished)
// DONE: IF RATING IS SET - DISPLAY it as text 
// DONE: MAKE ACCEPT REJECT BUTTONS ACTIVE only when story is finished and only for Author (invisible for officer)
// DONE: UPDATING STATUS W/LOGIC VIA AJAX 
// DONE: IF not ajax request, make a redirect



class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    // register globals set in application.ini
    public function _initConstants()
    {
	$hashsalt= $this->getOption('hashsalt');
	Zend_Registry::set('hashsalt', $hashsalt);
    }

}

