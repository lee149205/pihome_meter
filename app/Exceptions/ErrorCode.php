<?php

namespace App\Exceptions;

class ErrorCode
{
    const SERVER_ERROR = 'server_error';
    const NOT_FOUND = 'not_found';
    const VALIDATION_ERROR = 'validation_error';
    const USER_TOKEN_EXPIRED = 'user_token_expired';
    const USER_UNAUTHORIZED = 'user_unauthorized';
    const CLIENT_UNAUTHORIZED = 'client_unauthorized';
    const ACTION_UNAUTHORIZED = 'action_unauthorized';
    const FORBIDDEN = 'forbidden';
    const CODE_UNIQUE = 'code_unique';
}
