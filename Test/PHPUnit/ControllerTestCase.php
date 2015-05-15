<?php

/**
 * Functional testing scaffold for MVC applications
 *
 * @uses       PHPUnit_Framework_TestCase
 * @category   Zend
 * @package    Zend_Test
 * @subpackage PHPUnit
 */
abstract class REST_Test_PHPUnit_ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    
    /**
     * Retrieve test case response object
     *
     * @return Zend_Controller_Response_HttpTestCase
     */
    public function getResponse()
    {
        if (null === $this->_response) {
            require_once './ResponseTestCase.php';
            $this->_response = new REST_ResponseTestCase();
        }
        return $this->_response;
    }
}
