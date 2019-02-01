<?php

namespace Belt\Docs\Commands;

use Belt\Core\Commands\PublishCommand as Command;

/**
 * Class PublishCommand
 * @package Belt\Docs\Commands
 */
class PublishCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-docs:publish {action=publish} {--force} {--include=} {--exclude=} {--config}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish assets for belt docs';

    /**
     * @var array
     */
    protected $dirs = [
        'vendor/larabelt/docs/docs' => 'docs/raw',
    ];

}