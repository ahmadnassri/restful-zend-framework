<?php
/**
 * provides named constants for
 * HTTP protocol status codes.
 *
 */

class REST_Response
{
    // Informational 1xx
    const HTTP_CONTINUE         = 100;
    const SWITCH_PROTOCOLS      = 101;

    // Successful 2xx
    const OK                    = 200;
    const CREATED               = 201;
    const ACCEPTED              = 202;
    const NONAUTHORITATIVE_INFO = 203;
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
    const NAVAILABLE            = 503;
    const GATEWAY_TIMEOUT       = 504;
    const UNSUPPORTED_VERSION   = 505;
    const BANDWIDTH_EXCEEDED    = 509;

    protected static $messages = array(
        // Informational 1xx
        100 => 'Continue',
        101 => 'Switching Protocols',

        // Success 2xx
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',

        // Redirection 3xx
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',  // 1.1
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        // 306 is deprecated but reserved
        307 => 'Temporary Redirect',

        // Client Error 4xx
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',

        // Server Error 5xx
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        509 => 'Bandwidth Limit Exceeded'
    );
}
?>
