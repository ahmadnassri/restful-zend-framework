<?php
/**
 * Sample Index Resource
 */
class IndexController extends REST_Controller
{
    public function optionsAction()
    {
        $this->view->message = 'optionsAction has been called';
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function indexAction()
    {
        $this->view->message = 'indexAction has been called.';
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function headAction()
    {
        $this->view->message = 'headAction has been called';
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function getAction()
    {
        $this->view->message = 'getAction has been called';
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function postAction()
    {
        $this->view->message = 'postAction has been called';
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function putAction()
    {
        $this->view->message = 'putAction has been called';
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function deleteAction()
    {
        $this->view->message = 'deleteAction has been called';
        $this->getResponse()->setHttpResponseCode(200);
    }
}
