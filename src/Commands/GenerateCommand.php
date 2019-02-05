<?php

namespace Belt\Docs\Commands;

use Belt;
use Illuminate\Console\Command;

/**
 * Class GenerateCommand
 * @package Belt\Core\Commands
 */
class GenerateCommand extends Command
{

    use Belt\Core\Behaviors\HasService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-docs:generate {action=generate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate md document files for larabelt site';

    /**
     * @var string
     */
    protected $serviceClass = Belt\Docs\Services\GenerateService::class;

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        $action = $this->argument('action');

        $service = $this->service();

        if ($action == 'generate') {
            $service->generate();
        }
    }

}