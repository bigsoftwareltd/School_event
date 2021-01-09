<?php

namespace App\Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Event extends Model
{
    protected $table = 'photo_gallery';

    protected $guarded = ['id'];
    public static function galleryList()
    {
        return DB::table('photo_gallery')->join('photo','photo_gallery.id','=','photo.event_id')
            ->get([
                'event_id',
                'event_name',
                'date',
                'photo'
            ]);
    }
}
