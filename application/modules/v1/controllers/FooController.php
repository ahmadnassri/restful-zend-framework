<?php
/**
 *  Sample Foo Resource
 */
class FooController extends REST_Controller
{
    /**
     * The options action handles OPTIONS requests; it should respond with
     * the HTTP methods that the server supports for specified URL.
     */
    public function optionsAction()
    {
        $this->view->message = 'Resource Options';
        $this->getResponse()->setHttpResponseCode(200);
    }

    /**
     * The index action handles index/list requests; it should respond with a
     * list of the requested resources.
     */
    public function indexAction()
    {
        $this->view->resources = array();
        $this->getResponse()->setHttpResponseCode(200);
    }

    /**
     * The head action handles HEAD requests; it should respond with an
     * identical response to the one that would correspond to a GET request,
     * but without the response body.
     */
    public function headAction()
    {
        $this->getResponse()->setHttpResponseCode(200);
    }

    /**
     * The get action handles GET requests and receives an 'id' parameter; it
     * should respond with the server resource state of the resource identified
     * by the 'id' value.
     */
    public function getAction()
    {
        $this->view->id = $this->_getParam('id');
        $this->view->resource = new stdClass;
        $this->getResponse()->setHttpResponseCode(200);
    }

    /**
     * The post action handles POST requests; it should accept and digest a
     * POSTed resource representation and persist the resource state.
     */
    public function postAction()
    {
        $this->view->message = 'Resource Created';
        $this->getResponse()->setHttpResponseCode(201);
    }

    /**
     * The put action handles PUT requests and receives an 'id' parameter; it
     * should update the server resource state of the resource identified by
     * the 'id' value.
     */
    public function putAction()
    {
        $this->view->message = sprintf('Resource #%s Updated', $this->_getParam('id'));
        $this->getResponse()->setHttpResponseCode(201);
    }

    /**
     * The delete action handles DELETE requests and receives an 'id'
     * parameter; it should update the server resource state of the resource
     * identified by the 'id' value.
     */
    public function deleteAction()
    {
        $this->view->message = sprintf('Resource #%s Deleted', $this->_getParam('id'));
        $this->getResponse()->setHttpResponseCode(200);
    }
}
