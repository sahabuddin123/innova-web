<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\CoursesContract;
use App\Contracts\BatchsContract;
use App\Contracts\FeesTransactionsContract;
use App\Contracts\StudentsContract;
use App\Contracts\SessionContract;
use App\Contracts\RegistrationContract;
use App\Contracts\SliderContract;
use App\Contracts\SuccessStoryContract;
use App\Contracts\InvestmentContact;
use App\Contracts\ShareHolderContact;
use App\Contracts\AdmissionContact;
use App\Contracts\CertificateContact;
use App\Contracts\ReviewsContract;
use App\Contracts\BlogContract;
use App\Contracts\cmsAboutContact;
use App\Contracts\SeminorContract;
use App\Contracts\GalleryContract;
use App\Contracts\AssetContract;

use App\Repositories\CoursesRepository;
use App\Repositories\BatchsRepository;
use App\Repositories\FeesTransectionsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\SessionsRepository;
use App\Repositories\RegistrationsRepository;
use App\Repositories\SliderRepository;
use App\Repositories\SuccessStoryRepository;
use App\Repositories\InvestmentRepository;
use App\Repositories\ShareHolderRepository;
use App\Repositories\AdmissionRepository;
use App\Repositories\CertificateRepository;
use  App\Repositories\ReviewsRepository;
use  App\Repositories\BlogRepository;
use  App\Repositories\cmsAboutRepository;
use  App\Repositories\SeminorRepository;
use  App\Repositories\GalleryRepository;
use  App\Repositories\AssetRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        CoursesContract::class               =>          CoursesRepository::class,
        BatchsContract::class                =>          BatchsRepository::class,
        FeesTransactionsContract::class      =>          FeesTransectionsRepository::class,
        StudentsContract::class              =>          StudentsRepository::class,
        SessionContract::class               =>          SessionsRepository::class,
        RegistrationContract::class          =>          RegistrationsRepository::class,
        SliderContract::class                =>          SliderRepository::class,
        SuccessStoryContract::class          =>          SuccessStoryRepository::class,
        InvestmentContact::class             =>          InvestmentRepository::class,
        ShareHolderContact::class            =>          ShareHolderRepository::class,
        AdmissionContact::class              =>          AdmissionRepository::class,
        CertificateContact::class            =>          CertificateRepository::class,
        ReviewsContract::class               =>          ReviewsRepository::class,
        BlogContract::class                  =>          BlogRepository::class,
        cmsAboutContact::class               =>          cmsAboutRepository::class,
        SeminorContract::class               =>          SeminorRepository::class,
        GalleryContract::class               =>          GalleryRepository::class,
        AssetContract::class                 =>          AssetRepository::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }
}
