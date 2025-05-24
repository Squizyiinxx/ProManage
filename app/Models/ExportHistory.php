<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExportHistory extends Model
{
    use HasFactory,HasUuids;

    protected $table = 'export_histories';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'file_path',
    ];
        
}
