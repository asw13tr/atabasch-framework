<?php

namespace Atabasch\Core;

class HttpStatusCode {
    public $SWITCHING_PROTOCOLS = 101;
    public $OK = 200;
    public $CREATED = 201;
    public $ACCEPTED = 202;
    public $NONAUTHORITATIVE_INFORMATION = 203;
    public $NO_CONTENT = 204;
    public $RESET_CONTENT = 205;
    public $PARTIAL_CONTENT = 206;
    public $MULTIPLE_CHOICES = 300;
    public $MOVED_PERMANENTLY = 301;
    public $MOVED_TEMPORARILY = 302;
    public $SEE_OTHER = 303;
    public $NOT_MODIFIED = 304;
    public $USE_PROXY = 305;
    public $BAD_REQUEST = 400;
    public $UNAUTHORIZED = 401;
    public $PAYMENT_REQUIRED = 402;
    public $FORBIDDEN = 403;
    public $NOT_FOUND = 404;
    public $METHOD_NOT_ALLOWED = 405;
    public $NOT_ACCEPTABLE = 406;
    public $PROXY_AUTHENTICATION_REQUIRED = 407;
    public $REQUEST_TIMEOUT = 408;
    public $CONFLICT = 408;
    public $GONE = 410;
    public $LENGTH_REQUIRED = 411;
    public $PRECONDITION_FAILED = 412;
    public $REQUEST_ENTITY_TOO_LARGE = 413;
    public $REQUESTURI_TOO_LARGE = 414;
    public $UNSUPPORTED_MEDIA_TYPE = 415;
    public $REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    public $EXPECTATION_FAILED = 417;
    public $IM_A_TEAPOT = 418;
    public $INTERNAL_SERVER_ERROR = 500;
    public $NOT_IMPLEMENTED = 501;
    public $BAD_GATEWAY = 502;
    public $SERVICE_UNAVAILABLE = 503;
    public $GATEWAY_TIMEOUT = 504;
    public $HTTP_VERSION_NOT_SUPPORTED = 505;
}