<?php

namespace Wasinpwg\OpenlaravelTestGenerator;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Wasinpwg\OpenlaravelTestGenerator\Commands\OpenlaravelTestGeneratorCommand;

class OpenlaravelTestGeneratorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('openlaravel-test-generator')
            ->hasConfigFile('openlaravel-test-generator')
            ->hasViews()
            ->hasMigration('create_openlaravel-test-generator_table')
            ->hasCommand(OpenlaravelTestGeneratorCommand::class);
    }
}
