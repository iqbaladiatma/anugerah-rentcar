<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule file upload cleanup tasks
use Illuminate\Console\Scheduling\Schedule;

app(Schedule::class)->command('file-upload:cleanup')
    ->daily()
    ->at('02:00')
    ->description('Clean up old quarantined files and temporary uploads');

app(Schedule::class)->command('file-upload:cleanup --temp-hours=1')
    ->hourly()
    ->description('Clean up temporary files older than 1 hour');

// Schedule notification generation tasks
app(Schedule::class)->command('notifications:generate')
    ->everyFifteenMinutes()
    ->description('Generate system notifications for maintenance, payments, etc.');

app(Schedule::class)->command('notifications:cleanup --days=30')
    ->daily()
    ->at('03:00')
    ->description('Clean up old read notifications older than 30 days');
