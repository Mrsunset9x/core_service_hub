<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use Illuminate\Console\Command;
use Nwidart\Modules\Commands\ModuleMakeCommand;
use Symfony\Component\Console\Input\InputArgument;

class CoreMakeModule extends ModuleMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $names = $this->argument('name');
        parent::handle();

        $modulePath = module_path($names[0]);
        $modulePath = $modulePath . '/Polices';
        Helper::makeDirectory($modulePath);

        return 0;
    }

}
