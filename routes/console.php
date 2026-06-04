<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; // ضروري جداً للاستدعاء

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// أضيفي هذا السطر هنا لتشغيل أمر التنظيف كل ساعة تلقائياً
Schedule::command('code:clean')->hourly();
