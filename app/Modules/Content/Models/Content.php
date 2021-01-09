<?php

namespace App\Modules\Content\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'content';

    protected $guarded = ['id'];
    public static function contentList()
    {
        return Content::orderby('id','desc')
            ->get([
                'id',
                'title',
                'description',
                'image',
            ]);
    }
}
