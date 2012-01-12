<?php
class REST_ResponseCode
{
    const OK                  = 200; // The request has succeeded.
    const CREATED             = 201; // The request has been fulfilled and resulted in a new resource being created.
    const NO_CONTENT          = 204; // The server has fulfilled the request but does not need to return an entity-body.
    const MOVED_PERM          = 301;
    const FOUND               = 302;
    const NOT_MODIFIED        = 304;
    const TEMP_REDERICT       = 307;
    const BAD_REQUEST         = 400; // The request could not be understood by the server due to malformed syntax.
    const UNAUTHORIZED        = 401; // The request requires user authentication.
    const FORBIDDEN           = 403; // The server understood the request, but is refusing to fulfill it.
    const NOT_FOUND           = 404; // The server has not found anything matching the Request-URI
    const NOT_ALLOWED         = 405; // The method specified in the Request-Line is not allowed for the resource identified by the Request-URI
    const NOT_ACCEPTABLE      = 406; // The server can only generate a response that is not accepted by the client 
    const REQUEST_TIMEOUT     = 408;
    const SERVER_ERROR        = 500;
    const NOT_IMPLEMENTED     = 501; // The server does not support the functionality required to fulfill the request.
    const UNAVAILABLE         = 503;
    const TIMEOUT             = 504;    
};

