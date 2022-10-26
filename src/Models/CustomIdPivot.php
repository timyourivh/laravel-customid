<?php

namespace TimYouri\CustomId\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use TimYouri\CustomId\Traits\GeneratesCustomId;

class CustomIdPivot extends Pivot
{
    use GeneratesCustomId;
}
