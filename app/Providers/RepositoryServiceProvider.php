<?php

namespace App\Providers;

use App\Repository\Job\JobInterface;
use App\Repository\Job\JobRepository;
use App\Repository\User\UserInterface;
use App\Repository\Units\UnitInterface;
use App\Repository\User\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repository\Bazar\BazarInterface;
use App\Repository\Units\UnitRepository;
use App\Repository\Bazar\BazarRepository;
use App\Repository\Owners\OwnerInterface;
use App\Repository\Owners\OwnerRepository;
use App\Repository\Wallet\WalletInterface;
use App\Repository\Wallet\WalletRepository;
use App\Repository\Contact\ContactInterface;
use App\Repository\Project\ProjectInterface;
use App\Repository\Contact\ContactRepository;
use App\Repository\Project\ProjectRepository;
use App\Repository\Social\Post\PostInterface;
use App\Repository\ParkUser\ParkUserInterface;
use App\Repository\Social\Post\PostRepository;
use App\Repository\ParkUser\ParkUserRepository;
use App\Repository\SeekMoney\seekMoneyInterface;
use App\Repository\SeekMoney\seekMoneyRepository;
use App\Repository\UnitsImages\UnitImageInterface;
use App\Repository\UserWallet\UserWalletInterface;
use App\Repository\Social\Comment\CommentInterface;
use App\Repository\UnitsImages\UnitImageRepository;
use App\Repository\UserWallet\UserWalletRepository;
use App\Repository\WalletUnits\WalletUnitInterface;
use App\Repository\Reservation\ReservationInterface;
use App\Repository\SellProject\SellProjectInterface;
use App\Repository\Social\Comment\CommentRepository;
use App\Repository\WalletUnits\WalletUnitRepository;
use App\Repository\Reservation\ReservationRepository;
use App\Repository\SellProject\SellProjectRepository;
use App\Repository\BazarCustomer\BazarCustomerInterface;
use App\Repository\Souqistanboul\SouqistanboulInterface;
use App\Repository\BazarCustomer\BazarCustomerRepository;
use App\Repository\Souqistanboul\SouqistanboulRepository;
use App\Repository\CityCenterUsers\CityCenterUsersInterface;
use App\Repository\CityCenterUsers\CityCenterUsersRepository;





class RepositoryServiceProvider extends ServiceProvider
{
   
    public function register()
    {
        $this->app->bind(ProjectInterface::class,ProjectRepository::class);
        $this->app->bind(UnitInterface::class,UnitRepository::class);
        $this->app->bind(UnitImageInterface::class,UnitImageRepository::class);
        $this->app->bind(BazarInterface::class,BazarRepository::class);
        $this->app->bind(BazarCustomerInterface::class,BazarCustomerRepository::class);
        $this->app->bind(ReservationInterface::class,ReservationRepository::class);
        $this->app->bind(ContactInterface::class,ContactRepository::class);
        $this->app->bind(CityCenterUsersInterface::class,CityCenterUsersRepository::class);
        $this->app->bind(OwnerInterface::class,OwnerRepository::class);
        $this->app->bind(seekMoneyInterface::class,seekMoneyRepository::class);
        $this->app->bind(WalletInterface::class,WalletRepository::class);
        $this->app->bind(JobInterface::class,JobRepository::class);
        $this->app->bind(UserInterface::class,UserRepository::class);
        $this->app->bind(PostInterface::class,PostRepository::class);
        $this->app->bind(CommentInterface::class,CommentRepository::class);
        $this->app->bind(WalletUnitInterface::class,WalletUnitRepository::class);     
        $this->app->bind(UserWalletInterface::class,UserWalletRepository::class);     
        $this->app->bind(ParkUserInterface::class,ParkUserRepository::class);     
        $this->app->bind(SellProjectInterface::class,SellProjectRepository::class);
        $this->app->bind(SouqistanboulInterface::class, SouqistanboulRepository::class);




     

    }
    

    public function boot()
    {
        //
    }
}
