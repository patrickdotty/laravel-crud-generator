<?php

namespace Dottystyle\LaravelCrudGenerator\Console\Commands;

use Illuminate\Console\Command;

class ServiceGeneratorCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
   protected $signature = 'make:service {name : Service name (singular) for example VideoService} {model: Class (singular) for example User}';

   //const STUBS_PATH = base_path('resources/stubs/');

   /**
    * The console command description.
    *
    * @var string
    */
   protected $description = 'Create Service and Contracts files';

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
        $model = $this->argument('model');

        $this->info("Building Service for {$name}!");
        
        $model = ($model) ? $model : $name;
        $this->interface($name);
        $this->service($name);
        
       $this->info("{$name} Service successfully created!");       
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
    * Create service using stub.
    *
    * @return void
    */
    protected function service($name, $model)
    {
        $serviceTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Service')
        );
        if(!is_dir(app_path("Models/{$model}/Services" ))) {
            \File::makeDirectory(app_path("Models/{$model}/Services"), $mode = 0777, true, true);
        }
        file_put_contents(app_path("Models/{$model}/Services/{$name}Service.php"), $serviceTemplate);
        $this->info("{$name}Service.php" . ' has been created successfully!');
    }

    /**
    * Create interface using stub.
    *
    * @return void
    */
    protected function interface($name, $model)
    {
        $serviceTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Interface')
        );
        if(!is_dir(app_path("Models/{$model}/Contracts" ))) {
            \File::makeDirectory(app_path("Models/{$model}/Contracts"), $mode = 0777, true, true);
        }
        file_put_contents(app_path("Models/{$model}/Contracts/{$name}Interface.php"), $serviceTemplate);
        $this->info("{$name}Interface.php" . ' has been created successfully!');
    }

}
