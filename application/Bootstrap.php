<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     *  initiate action helpers
     */
    protected function _initActionHelpers()
    {
        $contextSwitch = new REST_Controller_Action_Helper_ContextSwitch();
        Zend_Controller_Action_HelperBroker::addHelper($contextSwitch);

        $restContexts = new REST_Controller_Action_Helper_RestContexts();
        Zend_Controller_Action_HelperBroker::addHelper($restContexts);
    }

    /**
     * initiate custom request object
     */
    protected function _initRequest()
    {
        // Ensure front controller instance is present, and fetch it
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');

        // Initialize the request object
        $request = new REST_Controller_Request_Http();

        // Add it to the front controller
        $front->setRequest($request);

        return $request;
    }
}
