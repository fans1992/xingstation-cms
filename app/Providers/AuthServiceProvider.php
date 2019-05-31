<?php

namespace App\Providers;

use App\Http\Controllers\Material\V1\Models\Material;
use App\Http\Controllers\Work\V1\Models\Work;
use App\Policies\MaterialPolicy;
use App\Policies\WorkPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Material::class => MaterialPolicy::class,
        Work::class     => WorkPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
//
//        \Horizon::auth(function ($request) {
//            // 是否是超级管理员
//            return \Auth::user()->hasRole(['super-admin']);
//        });
    }
}
