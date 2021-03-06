<?php
/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'buildings';

    protected $fillable = [];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

    public function rooms()
    {
        return $this->hasMany('App\Models\Room', 'building_id', 'id');
    }

}
