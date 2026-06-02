<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VerificationCode; // تأكدي من استيراد الموديل

class CleanExpiredCodes extends Command
{
    /**
     * الاسم الذي ستكتبينه في الترمينال لتشغيل الأمر.
     * جعلناه بسيطاً: code:clean
     */
    protected $signature = 'code:clean';

    /**
     * وصف بسيط لما يفعله هذا الأمر.
     */
    protected $description = 'حذف أكواد التحقق التي انتهت صلاحيتها من قاعدة البيانات';

    /**
     * تنفيذ منطق الأمر.
     */
    public function handle()
    {
        // حذف السجلات التي تجاوزت وقت الانتهاء (expire_at)
        // أي أن expire_at أصغر من الوقت الحالي (now)
        $deletedCount = VerificationCode::where('expire_at', '<', now())->delete();

        // إظهار رسالة نجاح في الترمينال عند الانتهاء
        $this->info("تمت العملية بنجاح. تم حذف {$deletedCount} كود منتهي الصلاحية.");
    }
}
