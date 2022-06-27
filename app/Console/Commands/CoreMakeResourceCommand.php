<?php

namespace App\Console\Commands;

use Filament\Commands\MakeResourceCommand;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;


class CoreMakeResourceCommand extends MakeResourceCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:make:filament-resource {name?} {--soft-deletes} {--view} {--G|generate} {--S|simple} {--F|force} {--module=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle(): int
    {
        $nameModule = $this->option('module') ?? 'App';
        $modulePath = Module::find($nameModule);

        $usingApp = $nameModule === 'App';

        if (!$modulePath && $nameModule && !$usingApp) return 0;

        $namespace = $usingApp ? $nameModule : config('modules.namespace') . '\\' . $nameModule;

        $model = (string)Str::of($this->argument('name') ?? $this->askRequired('Model (e.g. `BlogPost`)', 'name'))
            ->studly()
            ->trim('/')
            ->trim('\\')
            ->trim(' ')
            ->studly()
            ->replace('/', '\\');

        if (blank($model)) {
            $model = 'Resource';
        }

        $modelClass = (string)Str::of($model)->afterLast('\\');
        $modelNamespace = $namespace;
        $pluralModelClass = (string)Str::of($modelClass)->pluralStudly();

        $resource = "{$model}Resource";
        $resourceClass = "{$modelClass}Resource";
        $resourceNamespace = $modelNamespace;
        $listResourcePageClass = "List{$pluralModelClass}";
        $manageResourcePageClass = "Manage{$pluralModelClass}";
        $createResourcePageClass = "Create{$modelClass}";
        $editResourcePageClass = "Edit{$modelClass}";
        $viewResourcePageClass = "View{$modelClass}";

        $baseResourcePath = ($usingApp ? app_path() : $modulePath->getPath()) . '\\Filament\\Resources\\' . $resource;
        $baseResourcePath = Str::of($baseResourcePath)->replace('\\', '/');
        $resourcePath = "{$baseResourcePath}.php";
        $resourcePagesDirectory = "{$baseResourcePath}/Pages";
        $listResourcePagePath = "{$resourcePagesDirectory}/{$listResourcePageClass}.php";
        $manageResourcePagePath = "{$resourcePagesDirectory}/{$manageResourcePageClass}.php";
        $createResourcePagePath = "{$resourcePagesDirectory}/{$createResourcePageClass}.php";
        $editResourcePagePath = "{$resourcePagesDirectory}/{$editResourcePageClass}.php";
        $viewResourcePagePath = "{$resourcePagesDirectory}/{$viewResourcePageClass}.php";

        if (!$this->option('force') && $this->checkForCollision([
                $resourcePath,
                $listResourcePagePath,
                $manageResourcePagePath,
                $createResourcePagePath,
                $editResourcePagePath,
                $viewResourcePagePath,
            ])) {
            return static::INVALID;
        }

        $pages = '';
        $pages .= '\'index\' => Pages\\' . ($this->option('simple') ? $manageResourcePageClass : $listResourcePageClass) . '::route(\'/\'),';

        if (!$this->option('simple')) {
            $pages .= PHP_EOL . "'create' => Pages\\{$createResourcePageClass}::route('/create'),";

            if ($this->option('view')) {
                $pages .= PHP_EOL . "'view' => Pages\\{$viewResourcePageClass}::route('/{record}'),";
            }

            $pages .= PHP_EOL . "'edit' => Pages\\{$editResourcePageClass}::route('/{record}/edit'),";
        }

        $tableActions = [];

        if ($this->option('view')) {
            $tableActions[] = 'Tables\Actions\ViewAction::make(),';
        }

        $tableActions[] = 'Tables\Actions\EditAction::make(),';

        $relations = '';

        if ($this->option('simple')) {
            $tableActions[] = 'Tables\Actions\DeleteAction::make(),';

            if ($this->option('soft-deletes')) {
                $tableActions[] = 'Tables\Actions\ForceDeleteAction::make(),';
                $tableActions[] = 'Tables\Actions\RestoreAction::make(),';
            }
        } else {
            $relations .= PHP_EOL . 'public static function getRelations(): array';
            $relations .= PHP_EOL . '{';
            $relations .= PHP_EOL . '    return [';
            $relations .= PHP_EOL . '        //';
            $relations .= PHP_EOL . '    ];';
            $relations .= PHP_EOL . '}' . PHP_EOL;
        }

        $tableActions = implode(PHP_EOL, $tableActions);

        $tableBulkActions = [];

        $tableBulkActions[] = 'Tables\Actions\DeleteBulkAction::make(),';

        $eloquentQuery = '';

        if ($this->option('soft-deletes')) {
            $tableBulkActions[] = 'Tables\Actions\RestoreBulkAction::make(),';
            $tableBulkActions[] = 'Tables\Actions\ForceDeleteBulkAction::make(),';

            $eloquentQuery .= PHP_EOL . PHP_EOL . 'public static function getEloquentQuery(): Builder';
            $eloquentQuery .= PHP_EOL . '{';
            $eloquentQuery .= PHP_EOL . '    return parent::getEloquentQuery()';
            $eloquentQuery .= PHP_EOL . '        ->withoutGlobalScopes([';
            $eloquentQuery .= PHP_EOL . '            SoftDeletingScope::class,';
            $eloquentQuery .= PHP_EOL . '        ]);';
            $eloquentQuery .= PHP_EOL . '}';
        }

        $tableBulkActions = implode(PHP_EOL, $tableBulkActions);

        $this->copyStubToApp('Resource', $resourcePath, [
            'eloquentQuery' => $this->indentString($eloquentQuery, 1),
            'formSchema' => $this->option('generate') ? $this->getResourceFormSchema(
                ($modelNamespace !== '' ? $modelNamespace : 'App\Models') . '\\' . $modelClass,
            ) : $this->indentString('//', 4),
            'model' => $model === 'Resource' ? 'Resource as ResourceModel' : $model,
            'modelClass' => $model === 'Resource' ? 'ResourceModel' : $modelClass,
            'namespace' => ($resourceNamespace !== '' ? "{$resourceNamespace}" : ''),
            'pages' => $this->indentString($pages, 3),
            'relations' => $this->indentString($relations, 1),
            'resource' => $resource,
            'resourceClass' => $resourceClass,
            'tableActions' => $this->indentString($tableActions, 4),
            'tableBulkActions' => $this->indentString($tableBulkActions, 4),
            'tableColumns' => $this->option('generate') ? $this->getResourceTableColumns(
                ($modelNamespace !== '' ? $modelNamespace : 'App\Models') . '\\' . $modelClass
            ) : $this->indentString('//', 4),
            'tableFilters' => $this->indentString(
                $this->option('soft-deletes') ? 'Tables\Filters\TrashedFilter::make(),' : '//',
                4,
            ),
        ]);

        if ($this->option('simple')) {
            $this->copyStubToApp('ResourceManagePage', $manageResourcePagePath, [
                'namespace' => "{$modelNamespace}\\Filament\\Resources\\{$resource}\\Pages",
                'resource' => $resource,
                'resourceClass' => $resourceClass,
                'resourcePageClass' => $manageResourcePageClass,
            ]);
        } else {
            $this->copyStubToApp('ResourceListPage', $listResourcePagePath, [
                'namespace' => "{$modelNamespace}",
                'resource' => $resource,
                'resourceClass' => $resourceClass,
                'resourcePageClass' => $listResourcePageClass,
            ]);

            $this->copyStubToApp('ResourcePage', $createResourcePagePath, [
                'baseResourcePage' => 'Filament\\Resources\\Pages\\CreateRecord',
                'baseResourcePageClass' => 'CreateRecord',
                'namespace' => "{$modelNamespace}",
                'resource' => $resource,
                'resourceClass' => $resourceClass,
                'resourcePageClass' => $createResourcePageClass,
            ]);

            $editPageActions = [];

            if ($this->option('view')) {
                $this->copyStubToApp('ResourceViewPage', $viewResourcePagePath, [
                    'namespace' => "{$modelNamespace}",
                    'resource' => $resource,
                    'resourceClass' => $resourceClass,
                    'resourcePageClass' => $viewResourcePageClass,
                ]);

                $editPageActions[] = 'Actions\ViewAction::make(),';
            }

            $editPageActions[] = 'Actions\DeleteAction::make(),';

            if ($this->option('soft-deletes')) {
                $editPageActions[] = 'Actions\ForceDeleteAction::make(),';
                $editPageActions[] = 'Actions\RestoreAction::make(),';
            }

            $editPageActions = implode(PHP_EOL, $editPageActions);

            $this->copyStubToApp('ResourceEditPage', $editResourcePagePath, [
                'actions' => $this->indentString($editPageActions, 3),
                'namespace' => "{$modelNamespace}",
                'resource' => $resource,
                'resourceClass' => $resourceClass,
                'resourcePageClass' => $editResourcePageClass,
            ]);
        }

        $this->info("Successfully created {$resource}!");

        return static::SUCCESS;
    }
}
