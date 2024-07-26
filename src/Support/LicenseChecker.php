<?php

namespace Erjon\LaravelLicense\Support;

use Erjon\LaravelLicense\Models\ProjectLicense;

class LicenseChecker extends Output
{
    /**
     * @throws \Exception
     */
    public function activate(string $license): null|string
    {
        if($this->isActivated()) {
            if (app()->runningInConsole()) {
                $this->error('An license is currently active!');
            } else {
                throw new \Exception('An license is currently active!');
            }

            return null;
        }

        if(get_os() == 'Linux') {
            exec('cd '. __DIR__ .' && cd ../ && ./LicenseManager checkLicense ' . $license, $out);
        } else {
            exec('cd '. __DIR__ .' && cd ../ && LicenseManager checkLicense ' . $license, $out);
        }

        if($out[0] == "Correct license!" && isset($out[1])) {
            $this->saveLicense($out[1]);
            if (app()->runningInConsole()) {
                $this->success('License stored and is active!');
                return null;
            }

            return 'License stored and is active';
        }

        throw new \Exception('License is not correct!');
    }

    public function isActivated(): bool
    {
        $licenseExists = $this->projectNeedsLicense();
        if(! $licenseExists) {
            return true;
        }

        $fileLicense = $this->getFileLicense();

        if($this->databaseConnectionExists()) {
            $databaseLicense = $this->getDatabaseLicense();

            if(strcmp($fileLicense, $databaseLicense) != 0) {
                return false;
            }
        }
        return $this->decryptAndCheck($fileLicense);
    }

    private function projectNeedsLicense(): bool
    {
        try {
            $contents = file_get_contents(__DIR__.'/../.licenses.txt');
            if (trim($contents) == "") {
                return false;
            }

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    private function getFileLicense(): bool|string
    {
        try {
            $license = file_get_contents(__DIR__ . '/../.activated_licenses.txt');

            if(! $license) {
                return false;
            }

            return $license;
        } catch (\Exception $exception) {
            return false;
        }
    }

    private function getDatabaseLicense(): bool|string
    {
        if(ProjectLicense::count() == 0) {
            return false;
        }

        return ProjectLicense::first()->active;
    }

    private function decryptAndCheck(string $license): bool
    {
        try {

            if(get_os() == 'Linux') {
                exec('cd '. __DIR__ .' && cd ../ && ./LicenseManager decryptDatabaseLicense ' . escapeshellarg($license), $output);
            } else {
                exec('cd '. __DIR__ .' && cd ../ && LicenseManager decryptDatabaseLicense ' . escapeshellarg($license), $output);
            }

            $decryptedLicense = preg_replace('/Decrypted: /', '', $output[0]);

            if(get_os() == 'Linux') {
                exec('cd '. __DIR__ .' && cd ../ && ./LicenseManager checkLicense ' . $decryptedLicense, $out);
            } else {
                exec('cd '. __DIR__ .' && cd ../ && LicenseManager checkLicense ' . $decryptedLicense, $out);
            }

            if($out[0] == "Correct license!" && isset($out[1])) {
                return true;
            }

            return false;
        } catch (\Exception $exception) {
            return false;
        }
    }

    private function saveLicense(string $encryptedLicense): void
    {
        if($this->databaseConnectionExists()) {
            ProjectLicense::create([
                'active' => $encryptedLicense
            ]);
        }

        file_put_contents(__DIR__ . '/../.activated_licenses.txt', $encryptedLicense);
    }

    private function databaseConnectionExists(): bool
    {
        try {
            \DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
