<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class BaseSoftDeletesModel extends BaseModel
{
    use SoftDeletes;
}
