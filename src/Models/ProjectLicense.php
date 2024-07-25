<?php

namespace Erjon\LaravelLicense\Models;

use Erjon\LaravelLicense\Observers\ProjectLicenseObserver;
use Illuminate\Database\Eloquent\Model;

class ProjectLicense extends Model
{
    protected $table = 'project_license';

    protected $fillable = ['active'];

    protected static function booted()
    {
        static::observe(ProjectLicenseObserver::class);
    }
}
