<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    protected $table = 'routine';

    protected $primaryKey = 'routine_id';

    protected $fillable = ['device_id', 'title', 'description', 'frequency', 'last_done'];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
