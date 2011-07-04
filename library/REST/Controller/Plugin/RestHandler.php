<?php
class REST_Controller_Plugin_RestHandler extends Zend_Controller_Plugin_Abstract
{
    private $methods = array('OPTIONS', 'HEAD', 'INDEX', 'GET', 'POST', 'PUT', 'DELETE');

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $this->getResponse()->setHeader('Vary', 'Accept');

        if ($request->getParam('format') == null) {
            $mimeType = $this->getMimeType($request->getHeader('Accept'));

            switch ($mimeType) {
                case 'text/xml':
                case 'application/xml':
                    $request->setParam('format', 'xml');
                    break;

                case 'application/octet-stream':
                    $request->setParam('format', 'amf');
                    break;

                case 'text/php':
                    $request->setParam('format', 'php');
                    break;

                case 'application/json':
                    $request->setParam('format', 'json');
                    break;

                case 'text/csv':
                    $request->setParam('format', 'csv');
                    break;

                // TODO: add default in application.ini
                case '*/*':
                    $request->setParam('format', 'json');
                    break;

                default:
                    $request->setParam('format', 'json');
                    $request->dispatchError(406, 'Not Acceptable');
                    return;
            }
        }
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        if (!in_array(strtoupper($request->getMethod()), $this->methods))
        {
            $request->setActionName('options');
            $request->setDispatched(true);

            $this->getResponse()->setHttpResponseCode(405);

            return;
        }
        else
        {
            $contentType = $this->getMimeType($request->getHeader('Content-Type'));
            $rawBody = $request->getRawBody();

            if (!empty($rawBody))
            {
                try
                {
                    switch ($contentType)
                    {
                        case 'application/json':
                            $params = Zend_Json::decode($rawBody, Zend_Json::TYPE_OBJECT);
                            break;

                        case 'text/xml':
                        case 'application/xml':
                            $json = @Zend_Json::fromXml($rawBody);
                            $params = Zend_Json::decode($json, Zend_Json::TYPE_OBJECT)->request;
                            break;

                        case 'application/octet-stream':
                            $serializer = new Zend_Serializer_Adapter_Amf3();
                            $params = $serializer->unserialize($rawBody);
                            break;

                        case 'text/php':
                            $params = unserialize($rawBody);
                            break;

                        case 'multipart/form-data':
                        case 'application/x-www-form-urlencoded':
                            $params = array();
                            parse_str($rawBody, $params);
                            break;

                        default:
                            $params = $rawBody;
                            break;
                    }

                    $request->setParams((array) $params);
                }
                catch (Exception $e)
                {
                    $request->dispatchError(400, $e->getMessage());
                    return;
                }
            }
        }
    }

    private function getMimeType($mimeTypes = null)
    {
        // Values will be stored in this array
        $AcceptTypes = Array ();

        // Accept header is case insensitive, and whitespace isn't important
        $accept = strtolower(str_replace(' ', '', $mimeTypes));

        // divide it into parts in the place of a ","
        $accept = explode(',', $accept);

        foreach ($accept as $a)
        {
            // the default quality is 1.
            $q = 1;

            // check if there is a different quality
            if (strpos($a, ';q='))
            {
                // divide "mime/type;q=X" into two parts: "mime/type" i "X"
                list($a, $q) = explode(';q=', $a);
            } elseif (strpos($a, ';')) {
                list($a, ) = explode(';', $a);
            }

            // mime-type $a is accepted with the quality $q
            // WARNING: $q == 0 means, that mime-type isn't supported!
            $AcceptTypes[$a] = $q;
        }

        arsort($AcceptTypes);

        $AcceptTypes = array_flip($AcceptTypes);

        return array_shift($AcceptTypes);
    }
}
