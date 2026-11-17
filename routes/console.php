<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:setup', function () {
    $this->info('Running migrations...');
    Artisan::call('migrate', ['--force' => true]);
    $this->line(Artisan::output());

    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('admins') && \App\Models\Admin::count() === 0) {
            $this->info('Database is empty. Seeding initial data...');
            Artisan::call('db:seed', ['--force' => true]);
            $this->line(Artisan::output());
            $this->info('Database seeded successfully.');
        } else {
            $this->info('Database already contains admin data. Skipping seed.');
        }
    } catch (\Throwable $e) {
        $this->warn('Seeding check note: ' . $e->getMessage());
    }
})->purpose('Run migrations and initial seed if database is fresh');
