<?php

namespace App\Enums;

enum RedisCommand: string
{
    case GET = 'GET';
    case SET = 'SET';
    case RPUSH = 'RPUSH';
    case LPOP = 'LPOP';
}
