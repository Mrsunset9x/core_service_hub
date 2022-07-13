<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use BezhanSalleh\FilamentShield\Commands\MakeCreateShieldCommand;
use BezhanSalleh\FilamentShield\FilamentShield;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CoreMakeShieldCommand extends MakeCreateShieldCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $signature = 'shield:create {name?} {--module=}';

    /**
     * The console command description.
     *
     * @var string
     */
    public $description = 'Create Permissions and/or Policy for the given Filament Resource Model';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $module = $this->option('module') ?? null;
        $modulePath = module_path($module);

        $model = $this->generateModelName($this->argument('name') ?? $this->askRequired('Model (e.g. `Post or PostResource`)', 'name'));
        $policyPath = $this->generatePolicyPath($model);
        if ($modulePath) {
            $policyPath = $this->generatePolicyModulePath($model,$modulePath);
        }

        $choice = $this->choice('What would you like to Generate for the Resource?', [
            "Permissions & Policy",
            "Only Permissions",
            "Only Policy",
        ], 0, null, false);

        if ($choice === "Permissions & Policy") {
            if ($this->checkForCollision([$policyPath])) {
                return static::INVALID;
            }

            $this->copyStubToApp('DefaultPolicy', $policyPath, $this->generatePolicyStubVariables($model,$module));

            $this->info("Successfully generated {$model}Policy for {$model}Resource");

            FilamentShield::generateForResource($model);

            $this->info("Successfully generated Permissions for {$model}Resource");
        }

        if ($choice === "Only Permissions") {
            FilamentShield::generateForResource($model);

            $this->info("Successfully generated Permissions for {$model}Resource");
        }

        if ($choice === "Only Policy") {
            if ($this->checkForCollision([$policyPath])) {
                return static::INVALID;
            }

            $this->copyStubToApp('DefaultPolicy', $policyPath, $this->generatePolicyStubVariables($model,$module));

            $this->info("Successfully generated {$model}Policy for {$model}Resource");
        }

        return self::SUCCESS;
    }

    private function generatePolicyModulePath($model,$modulePath): string
    {
        $basePolicyPath = $modulePath .'\\'.
            (string) Str::of($model)
                ->prepend('Policies\\')
                ->replace('\\', '/');
        ;
        $basePolicyPath = str_replace('/','\\',$basePolicyPath);
        return "{$basePolicyPath}Policy.php";
    }

    protected function generatePolicyStubVariables(string $model,$module = null): array
    {
        $defaultPermissions = collect(config('filament-shield.prefixes.resource'))
            ->reduce(function ($gates, $permission) use ($model) {
                $gates[Str::studly($permission)] = $permission.'_'.Str::lower($model);

                return $gates;
            }, []);
        $defaultPermissions['modelPolicy'] = "{$model}Policy";
        if ($module) {
            $defaultPermissions['namespace'] = "Modules\\{$module}\\Policies";
        }
        return $defaultPermissions;
    }

}
