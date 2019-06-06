<?php

namespace Dottystyle\LaravelCrudGenerator\Console\Commands;

use Illuminate\Console\Command;

class LaravelCrudGeneratorCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
   protected $signature = 'make:crud {name : Class (singular) for example User} {--api}';

   //const STUBS_PATH = base_path('resources/stubs/');

   /**
    * The console command description.
    *
    * @var string
    */
   protected $description = 'Create Basic CRUD files';

   /**
    * Create a new command instance.
    *
    * @return void
    */
   public function __construct()
   {
       parent::__construct();
   }

   /**
    * Execute the console command.
    *
    * @return mixed
    */
   public function handle()
   {
       //

        $name = $this->argument('name');

        $api = ($this->option('api') == 1);

        $this->info("Building CRUD for {$name}!");
        $this->controller($name, $api);
        $this->model($name);
        $this->request($name);


        $this->resource($name);
        $this->collection($name);

       $this->info("{$name} CRUD successfully created!");
       \File::append(base_path('routes/api.php'), 'Route::resource(\'' . str_plural(strtolower($name)) . "', '{$name}Controller');");
   }

   /**
    * Get the stub file for the generator.
    *
    * @return string
    */
   protected function getStub($type)
   {
        return file_get_contents(base_path('vendor/dottystyle/laravel-crud-generator/resources/stubs/').$type.".stub");
   }

   /**
    * Create model using stub.
    *
    * @return void
    */
    protected function model($name)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );
        if(!is_dir(app_path("Models"))) {
            \File::makeDirectory(app_path("Models"), $mode = 0777, true, true);
        }
        file_put_contents(app_path("/Models/{$name}.php"), $modelTemplate);
        $this->info("{$name}.php" . ' has been created successfully!');
    }

    /**
    * Create controller using stub.
    *
    * @return void
    */
    protected function controller($name, $api = false)
    {
       $stub = ($api) ? "ApiController" : "Controller";
       $controllerTemplate = str_replace(
           [
               '{{modelName}}',
               '{{modelNamePluralLowerCase}}',
               '{{modelNameSingularLowerCase}}'
           ],
           [
               $name,
               strtolower(str_plural($name)),
               strtolower($name)
           ],
           $this->getStub($stub)
       );
        if($api) {
            if(!is_dir(app_path("/Http/Controllers/Api"))) {
                \File::makeDirectory(app_path("/Http/Controllers/Api"), $mode = 0777, true, true);
            }

            file_put_contents(app_path("/Http/Controllers/Api/{$name}Controller.php"), $controllerTemplate);
            $this->info("{$name}Controller.php" . ' has been successfully!');
        } else {
            file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
            $this->info("{$name}Controller.php" . ' has been created successfully!');
        }
    }

    /**
    * Create request using stub.
    *
    * @return void
    */
    protected function request($name)
    {
       $requestTemplate = str_replace(
           ['{{modelName}}'],
           [$name],
           $this->getStub('Request')
       );

       if(!file_exists($path = app_path('/Http/Requests')))
           mkdir($path, 0777, true);

       file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $requestTemplate);
       $this->info("{$name}Request.php" . ' has been created successfully!');
    }

    /**
    * Create resource using stub.
    *
    * @return void
    */
    protected function resource($name) {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Resource')
        );
        if(!file_exists($path = app_path('/Http/Resources')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Resources/{$name}.php"), $requestTemplate);
        $this->info("{$name}.php" . ' has been created successfully!');
    }

    /**
    * Create collection using stub.
    *
    * @return void
    */
    protected function collection($name) {
        $name = str_plural($name);
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Collection')
        );
        if(!file_exists($path = app_path('/Http/Resources')))
           mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Resources/{$name}.php"), $requestTemplate);
        $this->info("{$name}.php" . ' has been created successfully!');
    }


}
