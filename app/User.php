<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'is_active',
        'photo_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function role(){
        return $this->belongsTo('App\Role');
    }
    public function photo(){
        return $this->belongsTo('App\Photo');
    }
    //make the password not null, really i dont understand very well

    /**
     * It is comment because in the adminusercontroller we have one logic of password
     * encrypt, this is the reason, we have two encrypt passwords, this make a wrong password
     * in the db, a encrypt password, again encrypt


    public function setPasswordAttribute($password){
        if(!empty($password)){
        $this->attributes['password'] =bcrypt($password);
        }
    }
     * */

    public function isAdmin(){
        if($this->role->name == "administrator" && $this->is_active == 1){
            return true;
        }
        return false;
    }

}
