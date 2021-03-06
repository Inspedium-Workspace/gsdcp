<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_city()
    {
        return $this->belongsTo('App\Cities','city','id'); 
    }

    public function user_country()
    {
        return $this->belongsTo('App\Countries','country','idCountry'); 
    }

    public function user_kennels()
    {
        return $this->hasOne('App\Kennel','owner_id','id'); 
    }

    // public function litters()
    // {
    //     return $this->hasMany('App\LitterInspection','breeder_id'); 
    // }

    // public function user_role()
    // {
    //     return $this->belongsTo('App\Role','role_id','id'); 
    // }
}
