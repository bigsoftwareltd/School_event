<?php

namespace App\Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Downloads extends Model
{
    protected $table = 'downloads';

    protected $guarded = ['id'];
    public static function downloadList()
    {
        return DB::table('downloads')
            ->get([
                'id',
                'document_name',
                'date',
                'file',
            ]);
    }
}
