<?php

namespace App\Console\Commands\Generator;

use Illuminate\Console\Command;
use Prettus\Repository\Generators\Commands\RepositoryCommand;

class GenerateRepository extends RepositoryCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        config()->set('repository.generator.paths.interfaces','Repositories\\Interfaces');
        $this->laravel->call([$this, 'fire'], func_get_args());
        return 0;
    }
}
