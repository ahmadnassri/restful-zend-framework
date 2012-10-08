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
<?php
public function _initREST()
{
    $frontController = Zend_Controller_Front::getInstance();

    // set custom request object
    $frontController->setRequest(new REST_Request);
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
<?php
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

## Module Specific ErrorController issue

it seems there is an inherit issue with Zend Framework's modules & calling the  ErroController, basically ZF calls the default module's error controller for all modules.
This can be a problem of course if one of your modules is an API, you'll end up with HTML in the REST ErrorController output.

to fix this is beyond the scope of the REST library, so its only included in the README file:

in your ```application.ini```

```ini
resources.frontController.plugins.ErrorHandler.class = "Zend_Controller_Plugin_ErrorHandler"
resources.frontController.plugins.ErrorHandler.options.module = "default"
resources.frontController.plugins.ErrorHandler.options.controller = "error"
resources.frontController.plugins.ErrorHandler.options.action = "error"
```

then create a plugin to change the "module" scope, you can name this whatever you want, I went with ```App_Controller_Plugin_Errors```:

```php
<?php
class App_Controller_Plugin_Errors extends Zend_Controller_Plugin_Abstract
{
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $frontController = Zend_Controller_Front::getInstance();

        $error = $frontController->getPlugin('Zend_Controller_Plugin_ErrorHandler');

        $error->setErrorHandlerModule($request->getModuleName());
    }
}
```
