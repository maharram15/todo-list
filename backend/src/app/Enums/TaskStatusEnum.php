<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case DRAFT = 'draft';

    case NEW = 'new';

    case IN_PROGRESS = 'in-progress';

    case WONT_DO = 'wont-do';

    case COMPLETED = 'completed';
}
