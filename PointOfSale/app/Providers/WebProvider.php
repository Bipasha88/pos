<?php

namespace App\Providers;

use App\Repository\Branch\BranchRepository;
use App\Repository\Branch\IBranchRepository;
use App\Repository\Category\CategoryRepository;
use App\Repository\Category\ICategoryRepository;
use App\Repository\Business\BusinessRepository;
use App\Repository\Business\IBusinessRepository;
use App\Repository\Employee\EmployeeRepository;
use App\Repository\Employee\IEmployeeRepository;
use App\Repository\Product\IProductRepository;
use App\Repository\Product\ProductRepository;
use App\Repository\User\IUserRepository;
use App\Repository\User\UserRepository;
use App\Repository\Vendor\IVendorRepository;
use App\Repository\Vendor\VendorRepository;
use App\Services\Branch\BranchService;
use App\Services\Branch\IBranchService;
use App\Services\Category\CategoryService;
use App\Services\Category\ICategoryService;
use App\Services\Business\BusinessService;
use App\Services\Business\IBusinessService;
use App\Services\Employee\EmployeeService;
use App\Services\Employee\IEmployeeService;
use App\Services\Email\EmailService;
use App\Services\Email\IEmailService;
use App\Services\IMembershipService;
use App\Services\MembershipService;
use App\Services\Product\IProductService;
use App\Services\Product\ProductService;
use App\Services\Vendor\IVendorService;
use App\Services\Vendor\VendorService;
use App\Utility\ILogger;
use App\Utility\Logger;
use Illuminate\Support\ServiceProvider;

class WebProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IEmailService::class, EmailService::class);
        $this->app->bind(IBusinessService::class, BusinessService::class);
        $this->app->bind(IBusinessRepository::class, BusinessRepository::class);
        $this->app->bind(IEmployeeService::class, EmployeeService::class);
        $this->app->bind(IEmployeeRepository::class, EmployeeRepository::class);
        $this->app->bind(ILogger::class, Logger::class);
        $this->app->bind(IMembershipService::class, MembershipService::class);
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(IProductService::class, ProductService::class);
        $this->app->bind(IBranchRepository::class,BranchRepository::class);
        $this->app->bind(IBranchService::class,BranchService::class);
        $this->app->bind(IVendorService::class,VendorService::class);
        $this->app->bind(IVendorRepository::class,VendorRepository::class);
        $this->app->bind(ICategoryRepository::class,CategoryRepository::class);
        $this->app->bind(ICategoryService::class,CategoryService::class);
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
