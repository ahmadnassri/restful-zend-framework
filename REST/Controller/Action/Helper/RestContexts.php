<?php
class REST_Controller_Action_Helper_RestContexts extends Zend_Controller_Action_Helper_Abstract
{
    public function preDispatch()
    {
        $controller = $this->getActionController();

        if ($controller instanceOf Zend_Rest_Controller or $controller instanceOf REST_Controller) {
            $contextSwitch = $controller->getHelper('contextSwitch');
            $contextSwitch->setAutoSerialization(true);

            foreach ($this->getControllerActions($controller) as $action) {
                $contextSwitch->addActionContext($action, true);
            }

            $contextSwitch->initContext();
        }
    }

    private function getControllerActions($controller)
    {
        $class = new ReflectionObject($controller);
        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

        $actions = array();

        foreach ($methods as &$method) {
            $name = strtolower($method->name);

            if (substr($name, -6) == 'action') {
                $actions[] = str_replace('action', null, $name);
            }
        }

        return $actions;
    }
}
