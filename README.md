# RESTful Applications with Zend Framework [![Total views][sourcegraph-image]][sourcegraph-url]

This extension for Zend Framework, allows to create RESTful Controllers with ease.
please keep in mind that these instructions are general and you should probably customize the code to fit your needs.

for a working example please refer to [github.com/codeinchaos/restful-zend-framework-example](https://github.com/codeinchaos/restful-zend-framework-example)

## Assumptions
* you are building a mixed application (regular ZF Controllers + RESTful controllers)
* your controllers can be a a mix of regular controllers and RESTful controllers or a hybrid!

I recommend creating a separate [module](http://framework.zend.com/manual/1.12/en/zend.controller.modular.html) for the RESTful controllers, its less complicated to manage this way, and you don't have to worry about advanced REST routing ...
However, you can have pie and eat it too! It's possible to have any single Controller act as both a REST controller and a typical Zend MVC controller (HTML output).

In this particular example, I'm using a separate module "Api" that is purely used for REST API calls.

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

rest.default = "xml"
rest.formats[] = "json"
rest.formats[] = "xml"
```

the above achieves a couple of things:

1. Autoloads the REST library
2. sets the default respond format when all content type negotiation fails (in the above example: `xml`)
3. determines the list of content types you want to support in your API, built in types include: `html`, `xml`, `php`, `json`

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

In the above example, we are only enabling RESTful responses on a particular route, which is the `Api` module, look up the `Zend_Rest_Route` docs for further configuration options.

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

It seems there is an inherit issue with Zend Framework's modules & calling the  ErrorController, basically ZF calls the default module's error controller for all modules.
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

## Bugs and feature requests

Have a bug or a feature request? Please first read the [issue guidelines](CONTRIBUTING.md#using-the-issue-tracker) and search for existing and closed issues. If your problem or idea is not addressed yet, [please open a new issue](https://github.com/codeinchaos/restful-zend-framework/issues/new).

## Contributing

Please read through our [contributing guidelines](CONTRIBUTING.md). Included are directions for opening issues, coding standards, and notes on development.

More over, if your pull request contains JavaScript patches or features, you must include relevant unit tests.

Editor preferences are available in the [editor config](.editorconfig) for easy use in common text editors. Read more and download plugins at <http://editorconfig.org>.

### Contribute and Earn

Donate bitcoins to this project or make commits and get tips for it. If your commit is accepted by project maintainer and there are bitcoins on its balance, you will get a tip!

[![tip for next commit][tip4commit-image]][tip4commit-url]

## Donating

Donations are welcome to help support the continuous development of this project.

[![GitTip][gittip-image]][gittip-url]
[![PayPal][paypal-image]][paypal-url]

## Community

Keep track of development and updates.

- Follow [@AhmadNassri](http://twitter.com/ahmadnassri) & [@CodeInChaos](http://twitter.com/codeinchaos) on Twitter.
- Tweet [@CodeInChaos](http://twitter.com/codeinchaos) with any questions/personal support requests.
- Read and subscribe to [My Blog](http://ahmadnassri.com).

## Authors

**Ahmad Nassri**

- Twitter: [@AhmadNassri](http://twitter.com/ahmadnassri)
- Website: [ahmadnassri.com](http://ahmadnassri.com)

## License

Licensed under [the MIT license](LICENSE).

[sourcegraph-url]: https://sourcegraph.com/github.com/codeinchaos/restful-zend-framework
[sourcegraph-image]: https://sourcegraph.com/api/repos/github.com/codeinchaos/restful-zend-framework/counters/views.png
[gittip-url]: https://www.gittip.com/ahmadnassri/
[gittip-image]: http://img.shields.io/gittip/ahmadnassri.svg
[paypal-url]: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=UJ2B2BTK9VLRS&on0=project&os0=restful-zend-framework
[paypal-image]: http://img.shields.io/badge/PayPal-Donate-green.svg
[tip4commit-url]: http://tip4commit.com/projects/644
[tip4commit-image]: http://tip4commit.com/projects/644.svg
