<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
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

    public static function loginRules()
    {
        return [
            'email' => 'required|email|max:40|regex:/^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i',
            'password' => 'required|min:8|max:16',
        ];
    }

    public static function loginMessages()
    {
        return [
            'email.required' => 'Enter your email.',
            'email.max' => 'Email may not be greater than 40 character.',
            'password.required' => 'Enter your password.',
            'password.min' => 'Password must be at least 8 character.',
            'password.max' => 'Password may not be grater than 16 character.',
        ];
    }

    public static function rules()
    {
        return [
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|max:40|regex:/^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i|unique:users,email',
            'password' => 'required|min:8|max:16',
            'role' => 'required',
        ];
    }

    public static function messages()
    {
        return [
            'name.required' => 'Enter your name.',
            'name.max' => 'Name may not be greater than 20 character.',
            'email.required' => 'Enter your email.',
            'email.max' => 'Email may not be greater than 40 character.',
            'email.unique' => 'Email already exixts in our records.',
            'password.required' => 'Enter your password.',
            'password.min' => 'Password must be at least 8 character.',
            'password.max' => 'Password may not be grater than 16 character.',
            'role.required' => 'Select your role.',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }
}
