<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'repository', 'url', 'hash', 'prepared_at', 'standardised_at', 'suggested_at', 'cleaned_at', 'default_branch'
    ];
}
