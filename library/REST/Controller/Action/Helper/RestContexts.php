<?php
class REST_Controller_Action_Helper_RestContexts extends Zend_Controller_Action_Helper_Abstract
{
    protected $_contexts = array(
        'php',
        'xml',
        'json',
        'amf'
    );

    protected $_actions = array(
        'options',
        'head',
        'index',
        'get',
        'post',
        'put',
        'delete',
        'error'
    );

    public function preDispatch()
    {
        $controller = $this->getActionController();

        if (!$controller instanceof Zend_Rest_Controller)
        {
            return;
        }

        $this->_initContexts();
    }

    protected function _initContexts()
    {
        $contextSwitch = $this->getActionController()->getHelper('contextSwitch');

        $contextSwitch->setAutoSerialization(true);

        foreach ($this->_contexts as $context)
        {
            foreach ($this->_actions as $action)
            {
                $contextSwitch->addActionContext($action, $context);
            }
        }

        $contextSwitch->initContext();
    }
}
