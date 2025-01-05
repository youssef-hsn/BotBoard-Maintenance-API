<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Application extends Model implements JWTSubject {
    protected $table = 'application';

    protected $primaryKey = 'app_id';

    protected $fillable = ['username', 'app_secret'];

    protected static function booted() {    
        static::creating(function ($application) {
            $application->app_secret = bin2hex(random_bytes(16));
        });
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'mother_app', 'app_id');
    }

    public function getJWTIdentifier() {
        return $this->getKey(); 
    }

    public function getJWTCustomClaims()
    {
        return []; // Add custom claims if needed
    }

    public function getAuthIdentifierName()
    {
        return "app_id";
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }
}
