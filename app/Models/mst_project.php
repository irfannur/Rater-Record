<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_project extends Model
{
    use HasFactory;

    protected $primaryKey = 'idproject';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'projectname',
        'description',
        'rateperhour',
        'since_at'
    ];

    //protected $guarded = ['idproject'];
}
