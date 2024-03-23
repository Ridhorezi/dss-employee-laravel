<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Models\Assessment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Validator::extend('unique_assessment', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();

            $exists = Assessment::where([
                'employee_id' => $data['employee_id'],
                'criteria_id' => $parameters[0], // criteria_id
                'subcriteria_id' => $parameters[1], // subcriteria_id
            ])->exists();

            return !$exists;
        });
    }
}