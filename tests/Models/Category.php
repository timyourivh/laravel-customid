<?php

namespace TimYouri\CustomId\Test\Models;

use Illuminate\Database\Eloquent\Model;
use TimYouri\CustomId\Traits\GeneratesCustomId;
use Illuminate\Support\Str;

class Category extends Model
{
    use GeneratesCustomId;

    protected $guarded = [];
    public $timestamps = false;

    public function posts(){
        return $this->hasMany(Post::class);
    }

    protected function generateId(int $attempts)
    {
        return 'custom_category_id_' . Str::random(8);
    }
}