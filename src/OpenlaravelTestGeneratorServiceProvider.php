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
            ->name('openai-test-generator')
            ->hasConfigFile('openlaravel-test-generator')
            ->hasCommand(OpenlaravelTestGeneratorCommand::class);
    }
}
