<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\ClientePolicy;
use App\Policies\ProductoPolicy;
use App\Policies\CompraPolicy;
use App\Policies\ProveedorPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\VentaPolicy;

use App\Policies\Cliente;
use App\Policies\Compra;
use App\Policies\Producto;
use App\Policies\Proveedor;
use App\Policies\User;
use App\Policies\Venta;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Cliente::class => ClientePolicy::class,
        Producto::class => ProductoPolicy::class,
        Compra::class => CompraPolicy::class,
        Proveedor::class => ProveedorPolicy::class,
        User::class => UserPolicy::class,
        Venta::class => VentaPolicy::class,
        Role::class =>RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
