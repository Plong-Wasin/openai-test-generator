<?php

namespace Wasinpwg\OpenAITestGenerator;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Wasinpwg\OpenAITestGenerator\Commands\OpenAITestGeneratorCommand;

class OpenAITestGeneratorServiceProvider extends PackageServiceProvider
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
            ->hasConfigFile('openai-test-generator')
            ->hasCommand(OpenAITestGeneratorCommand::class);
    }
}
