<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Job extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'job_title', 'job_description',
    ];

    public static function rules()
    {
        return [
            'job_title' => 'required',
            'job_description' => 'required',
        ];
    }

    public static function messages()
    {
        return [
            'job_title.required' => 'Enter your job title.',
            'job_description.required' => 'Enter your job description.',
        ];
    }
}
