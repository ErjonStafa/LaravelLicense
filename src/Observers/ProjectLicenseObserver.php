<?php

namespace Erjon\LaravelLicense\Observers;

use Erjon\LaravelLicense\Models\ProjectLicense;

class ProjectLicenseObserver
{
    /**
     * Handle the ProjectLicense "creating" event.
     */
    public function creating(ProjectLicense $projectLicense)
    {
        if (ProjectLicense::count() >= 1) {
            throw new \Exception("No new license please :)");
        }
        return true;
    }

    /**
     * Handle the ProjectLicense "updating" event.
     */
    public function updating(ProjectLicense $projectLicense)
    {
        throw new \Exception("No new license please :)");
    }

    /**
     * Handle the ProjectLicense "deleting" event.
     */
    public function deleting(ProjectLicense $projectLicense)
    {
        throw new \Exception("No new license please :)");
    }
}
