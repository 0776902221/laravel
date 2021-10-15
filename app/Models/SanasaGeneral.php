<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanasaGeneral extends Model
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $table = 'sanasa_generals';

    protected $fillable = [
    'slpost_ref',
    'vehicle_number',
    'vehicle_type',
    'chassis_no',
    'salutation',
    'name',
    'current_owner',
    'nic',
    'mobile_number',
    'address',
    'valid_from',
    'valid_to',
    'premium',
    'status',
    'post_office',
    'download_id',
    ];

    protected $hidden = [

    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}