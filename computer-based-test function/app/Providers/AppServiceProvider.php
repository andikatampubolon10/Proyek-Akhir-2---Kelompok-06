<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Operator; 
use App\Policies\OperatorPolicy; 
class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Operator::class => OperatorPolicy::class, 
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Daftarkan gates jika diperlukan
        Gate::define('delete-operator', function (User  $user) {
            return $user->hasRole('Admin');
        });
    }
}
