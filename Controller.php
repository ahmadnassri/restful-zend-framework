<?php
/**
 * REST Controller default actions
 *
 */
abstract class REST_Controller extends Zend_Controller_Action
{
    /**
     * The index action handles index/list requests; it should respond with a
     * list of the requested resources.
     */
    abstract public function indexAction();

    /**
     * The get action handles GET requests and receives an 'id' parameter; it
     * should respond with the server resource state of the resource identified
     * by the 'id' value.
     */
    abstract public function getAction();

    /**
     * The post action handles POST requests; it should accept and digest a
     * POSTed resource representation and persist the resource state.
     */
    abstract public function postAction();

    /**
     * The put action handles PUT requests and receives an 'id' parameter; it
     * should update the server resource state of the resource identified by
     * the 'id' value.
     */
    abstract public function putAction();

    /**
     * The delete action handles DELETE requests and receives an 'id'
     * parameter; it should update the server resource state of the resource
     * identified by the 'id' value.
     */
    abstract public function deleteAction();

    /**
     * The head action handles HEAD requests; it should respond with an
     * identical response to the one that would correspond to a GET request,
     * but without the response body.
     */
    public function headAction()
    {
        $this->_forward('get');
    }

    /**
     * The options action handles OPTIONS requests; it should respond with
     * the HTTP methods that the server supports for specified URL.
     */
    public function optionsAction()
    {
        $class = new ReflectionObject($this);
        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

        $actions = array();

        foreach ($methods as &$method) {
            $name = strtoupper($method->name);

            if (substr($name, -6) == 'ACTION' && $name != 'INDEXACTION') {
                $actions[$name] = str_replace('ACTION', null, $name);
            }
        }

        $this->_response->setBody(null);
        $this->_response->setHeader('Allow', implode(', ', $actions));
        $this->_response->ok();
    }
}
