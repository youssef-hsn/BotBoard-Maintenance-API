<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Routine;

class Device extends Model
{
    protected $table = 'device';

    protected $primaryKey = 'device_id';

    protected $fillable = ['description', 'mother_app'];

    public function mother()
    {
        return $this->belongsTo(Application::class, 'mother_app', 'app_id');
    }

    public function applications()
    {
        return $this->belongsToMany(Application::class, 'device_apps', 'device_id', 'app_id');
    }

    public function routines()
    {
        return $this->hasMany(Routine::class, 'device_id');
    }
}
