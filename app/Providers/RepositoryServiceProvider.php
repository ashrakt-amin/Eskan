<?php

namespace App\Providers;

use App\Repository\Units\UnitInterface;
use Illuminate\Support\ServiceProvider;
use App\Repository\Units\UnitRepository;
use App\Repository\Project\ProjectInterface;
use App\Repository\Project\ProjectRepository;


class RepositoryServiceProvider extends ServiceProvider
{
   
    public function register()
    {
        $this->app->bind(ProjectInterface::class,ProjectRepository::class);
        $this->app->bind(UnitInterface::class,UnitRepository::class);





        
    
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
