<?php

namespace Erjon\LaravelLicense\Commands;

use Erjon\LaravelLicense\Facades\License;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class ActivateLicenseCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'license:activate {license}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate license for this program.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $license = $this->argument('license');

            License::activate($license);

            return Command::SUCCESS;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage() . '\n');
            return Command::FAILURE;
        }
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'license' => 'Please provide an license.'
        ];
    }
}
