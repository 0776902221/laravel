<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanasaGeneralDownload extends Model
{
    protected $table = 'sanasa_general_downloads';

    protected $fillable = [
        'from_date',
        'to_date',
        'count',
        'amount',


    ];

    protected $hidden = [

    ];

    public function sanasagenerals()
    {
        return $this->hasMany(SanasaGeneral::class);
    }
}
