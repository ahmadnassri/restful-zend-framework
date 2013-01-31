<?php
/**
 * provides named constants for
 * HTTP protocol status codes.
 *
 */

class REST_Response extends Zend_Controller_Response_Http
{
    // Informational 1xx
    const HTTP_CONTINUE         = 100;
    const SWITCH_PROTOCOLS      = 101;

    // Successful 2xx
    const OK                    = 200;
    const CREATED               = 201;
    const ACCEPTED              = 202;
    const NONAUTHORITATIVE      = 203;
    const NO_CONTENT            = 204;
    const RESET_CONTENT         = 205;
    const PARTIAL_CONTENT       = 206;

    // Redirection 3xx
    const MULTIPLE_CHOICES      = 300;
    const MOVED_PERMANENTLY     = 301;
    const FOUND                 = 302;
    const SEE_OTHER             = 303;
    const NOT_MODIFIED          = 304;
    const USE_PROXY             = 305;
    // 306 is deprecated but reserved
    const TEMP_REDIRECT         = 307;

    // Client Error 4xx
    const BAD_REQUEST           = 400;
    const UNAUTHORIZED          = 401;
    const PAYMENT_REQUIRED      = 402;
    const FORBIDDEN             = 403;
    const NOT_FOUND             = 404;
    const NOT_ALLOWED           = 405;
    const NOT_ACCEPTABLE        = 406;
    const PROXY_AUTH_REQUIRED   = 407;
    const REQUEST_TIMEOUT       = 408;
    const CONFLICT              = 409;
    const GONE                  = 410;
    const LENGTH_REQUIRED       = 411;
    const PRECONDITION_FAILED   = 412;
    const LARGE_REQUEST_ENTITY  = 413;
    const LONG_REQUEST_URI      = 414;
    const UNSUPPORTED_TYPE      = 415;
    const UNSATISFIABLE_RANGE   = 416;
    const EXPECTATION_FAILED    = 417;

    // Server Error 5xx
    const SERVER_ERROR          = 500;
    const NOT_IMPLEMENTED       = 501;
    const BAD_GATEWAY           = 502;
    const UNAVAILABLE           = 503;
    const GATEWAY_TIMEOUT       = 504;
    const UNSUPPORTED_VERSION   = 505;
    const BANDWIDTH_EXCEEDED    = 509;

    // Informational 1xx
    function httpContinue()
    {
        $this->setHttpResponseCode(self::HTTP_CONTINUE);
    }

    function switchProtocols()
    {
        $this->setHttpResponseCode(self::SWITCH_PROTOCOLS);
    }

    // Successful 2xx
    public function Ok()
    {
        $this->setHttpResponseCode(self::OK);
    }

    public function created()
    {
        $this->setHttpResponseCode(self::CREATED);
    }

    public function accepted()
    {
        $this->setHttpResponseCode(self::ACCEPTED);
    }

    public function nonAuthoritative()
    {
        $this->setHttpResponseCode(self::NONAUTHORITATIVE);
    }

    public function noContent()
    {
        $this->setHttpResponseCode(self::NO_CONTENT);
    }

    public function resetContent()
    {
        $this->setHttpResponseCode(self::RESET_CONTENT);
    }

    public function partialContent()
    {
        $this->setHttpResponseCode(self::PARTIAL_CONTENT);
    }

    // Redirection 3xx
    public function multipleChoices()
    {
        $this->setHttpResponseCode(self::MULTIPLE_CHOICES);
    }

    public function movedPermanently()
    {
        $this->setHttpResponseCode(self::MOVED_PERMANENTLY);
    }

    public function found()
    {
        $this->setHttpResponseCode(self::FOUND);
    }

    public function seeOther()
    {
        $this->setHttpResponseCode(self::NO_CONTENT);
    }

    public function notModified()
    {
        $this->setHttpResponseCode(self::NOT_MODIFIED);
    }

    public function useProxy()
    {
        $this->setHttpResponseCode(self::USE_PROXY);
    }

    public function tempRedirect()
    {
        $this->setHttpResponseCode(self::TEMP_REDIRECT);
    }

    // Client Error 4xx
    public function badRequest()
    {
        $this->setHttpResponseCode(self::BAD_REQUEST);
    }

    public function unauthorized()
    {
        $this->setHttpResponseCode(self::UNAUTHORIZED);
    }

    public function paymentRequired()
    {
        $this->setHttpResponseCode(self::PAYMENT_REQUIRED);
    }

    public function forbidden()
    {
        $this->setHttpResponseCode(self::FORBIDDEN);
    }

    public function notFound()
    {
        $this->setHttpResponseCode(self::NOT_FOUND);
    }

    public function notAllowed()
    {
        $this->setHttpResponseCode(self::NOT_ALLOWED);
    }

    public function notAcceptable()
    {
        $this->setHttpResponseCode(self::NOT_ACCEPTABLE);
    }

    public function proxyAuthRequired()
    {
        $this->setHttpResponseCode(self::PROXY_AUTH_REQUIRED);
    }

    public function requestTimeout()
    {
        $this->setHttpResponseCode(self::REQUEST_TIMEOUT);
    }

    public function conflict()
    {
        $this->setHttpResponseCode(self::CONFLICT);
    }

    public function gone()
    {
        $this->setHttpResponseCode(self::GONE);
    }

    public function lengthRequired()
    {
        $this->setHttpResponseCode(self::NO_CONTENT);
    }

    public function preconditionFailed()
    {
        $this->setHttpResponseCode(self::PRECONDITION_FAILED);
    }

    public function largeRequestEntity()
    {
        $this->setHttpResponseCode(self::LARGE_REQUEST_ENTITY);
    }

    public function longRequestUri()
    {
        $this->setHttpResponseCode(self::LONG_REQUEST_URI);
    }

    public function unsupportedType()
    {
        $this->setHttpResponseCode(self::UNSUPPORTED_TYPE);
    }

    public function unsatisfiableRange()
    {
        $this->setHttpResponseCode(self::UNSATISFIABLE_RANGE);
    }

    public function expectationFailed()
    {
        $this->setHttpResponseCode(self::EXPECTATION_FAILED);
    }

    // Server Error 5xx
    public function serverError()
    {
        $this->setHttpResponseCode(self::SERVER_ERROR);
    }

    public function notImplemented()
    {
        $this->setHttpResponseCode(self::NOT_IMPLEMENTED);
    }

    public function badGateway()
    {
        $this->setHttpResponseCode(self::BAD_GATEWAY);
    }

    public function unavailable()
    {
        $this->setHttpResponseCode(self::UNAVAILABLE);
    }

    public function gatewayTimeout()
    {
        $this->setHttpResponseCode(self::GATEWAY_TIMEOUT);
    }

    public function unsupportedVersion()
    {
        $this->setHttpResponseCode(self::UNSUPPORTED_VERSION);
    }

    public function bandwidthExceeded()
    {
        $this->setHttpResponseCode(self::BANDWIDTH_EXCEEDED);
    }


    /**
     * Return header value (if set); see {@link $_headers} for format
     *
     * @return string | boolean
     */
    public function getHeaderValue($name)
    {
        foreach ($this->_headers as $key => $header) {
            if ($name == $header['name']) {
                return $header['value'];
            }
        }

        return false;
    }
}
?>
