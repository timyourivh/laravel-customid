<?php

namespace TimYouri\CustomId\Test\Models;

use Illuminate\Database\Eloquent\Model;
use TimYouri\CustomId\Traits\GeneratesCustomId;
use Illuminate\Support\Str;

class Post extends Model
{
    use GeneratesCustomId;

    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    protected function generateId(int $attempts)
    {
        return 'custom_post_id_' . Str::random(8);
    }
}
