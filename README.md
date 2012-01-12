# RESTful Applications with Zend Framework

This extension for Zend Framework, allows to create RESTful Controllers with ease.
please keep in mind that these instructions are general and you should probably customize the code to fit your needs.

for a working example please refer to https://github.com/codeinchaos/restful-zend-framework-example

## Assumptions
* you are building a mixed application (regular ZF Controllers + RESTful controllers)
* the RESTful part is a separate module called "api"
* the "api" module may contain a mix of regular controllers and RESTful controllers

I recommend creating a separate module for the RESTful controllers, its less complicated to manage this way, and you don't have to worry about advanced REST routing ...

you can still create regular Controllers in the module, ex: landing page IndexController ... however if you want to setup advanced routing rules with those controllers, its going to be a hassle!

## Steps
1. Copy the **REST** directory into your **library**.
2. modify **application.ini**.
3. modify **application/Bootstrap.php**.
4. modify your RESTful module Bootstrap ex: **application/modules/api/Bootstrap.php**.
5. create Controllers as usual, just make sure they extends **REST_Controller**.
6. check https://github.com/codeinchaos/restful-zend-framework-example for examples.
7. reccomended: use the Api_ErrorController provided in the example above, modify to your needs.

### application.ini:

add the following:

```ini
autoloaderNamespaces[] = "REST_"
```

### application/Bootstrap.php

add the following:

```php
public function _initREST()
{
    $frontController = Zend_Controller_Front::getInstance();

    // set custom request object
    $frontController->setRequest(new REST_Controller_Request_Http);
    $frontController->setResponse(new REST_Response);

    // add the REST route for the API module only
    $restRoute = new Zend_Rest_Route($frontController, array(), array('api'));
    $frontController->getRouter()->addRoute('rest', $restRoute);
}
```

### application/modules/api/Bootstrap.php

**Note:** depending on your setup, you may want to setup some advanced rules to enable the **REST Plugin** and the **Action Helpers** only when needed.
I use a modified Bootstraping method called "Active Bootstrap" (google it) to only run the bootstrap **_init** methods per active module, which saves me a lot of headaches.

```php
public function _initREST()
{
    $frontController = Zend_Controller_Front::getInstance();

    // register the RestHandler plugin
    $frontController->registerPlugin(new REST_Controller_Plugin_RestHandler($frontController));

    // add REST contextSwitch helper
    $contextSwitch = new REST_Controller_Action_Helper_ContextSwitch();
    Zend_Controller_Action_HelperBroker::addHelper($contextSwitch);

    // add restContexts helper
    $restContexts = new REST_Controller_Action_Helper_RestContexts();
    Zend_Controller_Action_HelperBroker::addHelper($restContexts);
}
```
