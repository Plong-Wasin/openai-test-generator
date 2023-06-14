<?php

namespace Wasinpwg\OpenlaravelTestGenerator\Commands;

use Illuminate\Console\Command;

class OpenlaravelTestGeneratorCommand extends Command
{
    public $signature = 'openlaravel-test-generator';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
