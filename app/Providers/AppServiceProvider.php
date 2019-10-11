<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Repositories\Activity\ActivityRepository;
use App\Repositories\Activity\EloquentActivity;
use App\Repositories\Country\CountryRepository;
use App\Repositories\Country\EloquentCountry;
use App\Repositories\Permission\EloquentPermission;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Role\EloquentRole;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Session\DbSession;
use App\Repositories\Session\SessionRepository;
use App\Repositories\User\EloquentUser;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;


use App\Repositories\Department\EloquentDepartment;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\Option\EloquentOption;
use App\Repositories\Option\OptionRepository;
use App\Repositories\Clearance\EloquentClearance;
use App\Repositories\Clearance\ClearanceRepository;
use App\Repositories\Request\EloquentRequest;
use App\Repositories\Request\RequestRepository;
use App\Repositories\Result\EloquentResult;
use App\Repositories\Result\ResultRepository;
use App\Repositories\Hostel\EloquentHostel;
use App\Repositories\Hostel\HostelRepository;
use App\Repositories\Library\EloquentLibrary;
use App\Repositories\Library\LibraryRepository;
use App\Repositories\Registration\EloquentRegistration;
use App\Repositories\Registration\RegistrationRepository;
use App\Repositories\Finance\EloquentFinance;
use App\Repositories\Finance\FinanceRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        config(['app.name' => settings('app_name')]);
        \Illuminate\Database\Schema\Builder::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepository::class, EloquentUser::class);
        $this->app->singleton(ActivityRepository::class, EloquentActivity::class);
        $this->app->singleton(RoleRepository::class, EloquentRole::class);
        $this->app->singleton(PermissionRepository::class, EloquentPermission::class);
        $this->app->singleton(SessionRepository::class, DbSession::class);
        $this->app->singleton(CountryRepository::class, EloquentCountry::class);


        $this->app->singleton(DepartmentRepository::class, EloquentDepartment::class);
        $this->app->singleton(OptionRepository::class, EloquentOption::class);
        $this->app->singleton(ClearanceRepository::class, EloquentClearance::class);
        $this->app->singleton(RequestRepository::class, EloquentRequest::class);
        $this->app->singleton(ResultRepository::class, EloquentResult::class);
        $this->app->singleton(HostelRepository::class, EloquentHostel::class);
        $this->app->singleton(LibraryRepository::class, EloquentLibrary::class);
        $this->app->singleton(RegistrationRepository::class, EloquentRegistration::class);
        $this->app->singleton(FinanceRepository::class, EloquentFinance::class);

        if ($this->app->environment('local')) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
