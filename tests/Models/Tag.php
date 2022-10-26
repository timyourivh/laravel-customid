<?php

namespace TimYouri\CustomId\Test\Models;

use Illuminate\Database\Eloquent\Model;
use TimYouri\CustomId\Traits\GeneratesCustomId;
use Illuminate\Support\Str;

class Tag extends Model
{
    use GeneratesCustomId;

    protected $guarded = [];
    public $timestamps = false;

    public function posts(){
        return $this->belongsToMany(Post::class);
    }

    protected function generateId(int $attempts)
    {
        return 'custom_tag_id_' . Str::random(8);
    }
}
