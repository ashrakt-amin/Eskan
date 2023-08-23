<?php

namespace App\Providers;

use App\Repository\Units\UnitInterface;
use Illuminate\Support\ServiceProvider;
use App\Repository\Units\UnitRepository;
use App\Repository\Owners\OwnerInterface;
use App\Repository\Owners\OwnerRepository;
use App\Repository\Contact\ContactInterface;
use App\Repository\Project\ProjectInterface;
use App\Repository\Contact\ContactRepository;
use App\Repository\Project\ProjectRepository;
use App\Repository\SeekMoney\seekMoneyInterface;
use App\Repository\SeekMoney\seekMoneyRepository;
use App\Repository\UnitsImages\UnitImageInterface;
use App\Repository\UnitsImages\UnitImageRepository;
use App\Repository\Reservation\ReservationInterface;
use App\Repository\Reservation\ReservationRepository;
use App\Repository\CityCenterUsers\CityCenterUsersInterface;
use App\Repository\CityCenterUsers\CityCenterUsersRepository;
use App\Repository\Wallet\WalletInterface;
use App\Repository\Wallet\WalletRepository;

class RepositoryServiceProvider extends ServiceProvider
{
   
    public function register()
    {
        $this->app->bind(ProjectInterface::class,ProjectRepository::class);
        $this->app->bind(UnitInterface::class,UnitRepository::class);
        $this->app->bind(UnitImageInterface::class,UnitImageRepository::class);
        $this->app->bind(ReservationInterface::class,ReservationRepository::class);
        $this->app->bind(ContactInterface::class,ContactRepository::class);
        $this->app->bind(CityCenterUsersInterface::class,CityCenterUsersRepository::class);
        $this->app->bind(OwnerInterface::class,OwnerRepository::class);
        $this->app->bind(seekMoneyInterface::class,seekMoneyRepository::class);
        $this->app->bind(WalletInterface::class,WalletRepository::class);

      
    }
    

    public function boot()
    {
        //
    }
}
