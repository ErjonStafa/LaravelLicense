<?php

namespace Erjon\LaravelLicense\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class AddLicenseCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'license:add {license}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert a new license for this program.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $license = $this->argument('license');

        if(get_os() == 'Linux') {
            exec('cd '. __DIR__ .' && cd ../ && ./LicenseManager addLicense ' . $license, $out);
        } else {
            exec('cd '. __DIR__ .' && cd ../ && LicenseManager addLicense ' . $license, $out);
        }

        $this->info($out[0]);

        return Command::SUCCESS;
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'license' => 'Please provide an license.'
        ];
    }
}
