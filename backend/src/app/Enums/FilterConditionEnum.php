<?php

namespace App\Enums;

enum FilterConditionEnum: string
{
    case EQUAL = '=';

    case GREATER = '>';

    case LESS = '<';

    case NOT_EQUAL = '!';

    case GREATER_OR_EQUAL = '>=';

    case LESS_OR_EQUAL = '<=';

    case BETWEEN = '|';

    case NOT_BETWEEN = '!|';

    case IN_ARRAY = '@';

    public function toSqlCondition(): string
    {

    }
}
