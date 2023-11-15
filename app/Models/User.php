<?php

namespace App\Models;

use App\Domain\Constants\UserRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\File;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role'
    ]; 

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Set hash password attributes before save.
     *
     * @var array
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
 
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    /**
     * Return the path of avatar of user.
     *
     * @return string
     */
    public function avatar() {
        $extensions = ['jpeg', 'jpg', 'png'];
        foreach ($extensions as $extension) {
            $avatar = '/avatars/' . $this->id . "." . $extension;
            if (File::exists(public_path() . $avatar)) return env('APP_URL') . $avatar;
        }
        return env('APP_URL'). '/avatars/0.jpg';
    }

    /**
     * Return name role.
     *
     * @return string
     */
    public function convertRole() {
        switch($this->role) {
            case UserRoles::SUPER_ADMIN: 
                return "Super admin";
            default:
                return "Client";
        }
    }
}
