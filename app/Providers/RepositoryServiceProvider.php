<?php

namespace App\Providers;

use App\Repository\Units\UnitInterface;
use Illuminate\Support\ServiceProvider;
use App\Repository\Units\UnitRepository;
use App\Repository\Contact\ContactInterface;
use App\Repository\Project\ProjectInterface;
use App\Repository\Contact\ContactRepository;
use App\Repository\Project\ProjectRepository;
use App\Repository\Reservation\ReservationInterface;
use App\Repository\Reservation\ReservationRepository;
use App\Repository\CityCenterUsers\CityCenterUsersInterface;
use App\Repository\CityCenterUsers\CityCenterUsersRepository;


class RepositoryServiceProvider extends ServiceProvider
{
   
    public function register()
    {
        $this->app->bind(ProjectInterface::class,ProjectRepository::class);
        $this->app->bind(UnitInterface::class,UnitRepository::class);
        $this->app->bind(ReservationInterface::class,ReservationRepository::class);
        $this->app->bind(ContactInterface::class,ContactRepository::class);
        $this->app->bind(CityCenterUsersInterface::class,CityCenterUsersRepository::class);

        
        
    }

    public function boot()
    {
        //
    }
}
