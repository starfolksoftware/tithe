<?php

namespace Tithe\Commands;

use Illuminate\Console\Command;

class TitheCommand extends Command
{
    public $signature = 'tithe';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
