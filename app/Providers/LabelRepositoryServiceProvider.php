<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Label\LabelRepository;
use App\Repositories\Label\LabelRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class LabelRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->bind(LabelRepositoryInterface::class, LabelRepository::class);
    }
}
