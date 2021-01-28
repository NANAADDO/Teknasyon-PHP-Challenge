<?php
/**
 * Created by PhpStorm.
 * User: APPUSER3
 * Date: 10/8/2018
 * Time: 11:50 PM
 */

namespace App\Constants;


class StatusCodes
{
    const OK = 200;
    const OBJECT_CREATED = 201;
    const NO_CONTENT = 204;
    const NOT_FOUND = 404;
    const PARTIAL_CONTENT = 206;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const INTERNAL_SERVER_ERROR = 500;
    const SERVICE_UNAVAILABLE = 503;
}