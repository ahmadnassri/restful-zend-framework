<?php
class REST_Controller_Request_Http extends Zend_Controller_Request_Http
{
    private $_error = false;

    public function setError($code, $message)
    {
        $this->_error = new stdClass;
        $this->_error->code = $code;
        $this->_error->message = $message;

        return $this;
    }

    public function getError()
    {
        return $this->_error;
    }

    public function hasError()
    {
        return !($this->_error === false);
    }

    public function dispatchError($code, $message)
    {
        $this->setError($code, $message);

        $this->setControllerName('error');
        $this->setActionName('error');
        $this->setDispatched(true);
    }
}
