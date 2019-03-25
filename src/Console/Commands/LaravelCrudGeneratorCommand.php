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
       $this->controller($name, $api);
       
       $this->model($name);
       $this->request($name);

       \File::append(base_path('routes/api.php'), 'Route::resource(\'' . str_plural(strtolower($name)) . "', '{$name}Controller');");
   }
    
   /**
    * Get the stub file for the generator.
    *
    * @return string
    */
   protected function getStub($type)
   {
       return file_get_contents(resource_path("stubs/$type.stub"));
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

       file_put_contents(app_path("/Models/{$name}.php"), $modelTemplate);
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
           file_put_contents(app_path("/Http/Controllers/Api/{$name}Controller.php"), $controllerTemplate);
       } else {
           file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
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
   }

   protected function resource($name) {
       $requestTemplate = str_replace(
           ['{{modelName}}'],
           [$name],
           $this->getStub('Resource')
       );
   }

   protected function collection($name) {
       $requestTemplate = str_replace(
           ['{{modelName}}'],
           [$name],
           $this->getStub('Collection')
       );
   }


}
