<?php

namespace Henrik\Route\Utils;

enum RouteParamType: string
{
    case TYPE_STRING  = 'string';
    case TYPE_INTEGER = 'integer';
    case TYPE_ANY   = 'any';
}
