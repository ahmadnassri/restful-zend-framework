<?php
/**
 * RESTful Zend Framework
 *
 * @copyright  Copyright (c) 2011 Code in Chaos Inc. (http://www.codeinchaos.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * standard Zend Application generated ErrorController
 * with Zend_Rest_Controller inheritance
 */
class ErrorController extends REST_Controller
{
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');

        if (!$errors) {
            $this->view->message = 'You have reached the error page';
            return;
        }

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }

        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->crit($this->view->message, $errors->exception);
        }

        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception->getMessage();
        }

        $this->view->request   = $errors->request;
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }

    /**
     * Options Action
     *
     * @return void
     */
    public function optionsAction()
    {
    }

    /**
     * Index Action
     *
     * @return void
     */
    public function indexAction()
    {
    }

    /**
     * HEAD Action
     *
     * @return void
     */
    public function headAction()
    {
    }

    /**
     * GET Action
     *
     * @return void
     */
    public function getAction()
    {
    }

    /**
     * POST Action
     *
     * @return void
     */
    public function postAction()
    {
    }

    /**
     * PUT Action
     *
     * @return void
     */
    public function putAction()
    {
    }

    /**
     * DELETE Action
     *
     * @return void
     */
    public function deleteAction()
    {
    }
}

