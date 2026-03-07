<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Industry;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ReferenceDataSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'تسويق عبر السوشيال ميديا',
            'حملات المؤثرين',
            'إعلانات الأداء',
            'بناء الوعي بالعلامة التجارية',
            'توليد العملاء المحتملين',
            'إنتاج المحتوى',
        ];

        $industries = [
            'التجزئة',
            'الأغذية والمشروبات',
            'التجارة الإلكترونية',
            'التعليم',
            'الرعاية الصحية',
            'العقارات',
            'التقنية المالية',
            'السياحة والسفر',
        ];

        $services = [
            'إدارة حسابات التواصل الاجتماعي',
            'الإعلانات المدفوعة',
            'التصميم الإبداعي',
            'كتابة المحتوى',
            'إنتاج الفيديو',
            'تحسين محركات البحث (SEO)',
            'استراتيجيات التسويق',
            'إدارة حملات المؤثرين',
        ];

        foreach ($categories as $name) {
            Category::query()->updateOrCreate(['name' => $name], ['is_active' => true]);
        }

        foreach ($industries as $name) {
            Industry::query()->updateOrCreate(['name' => $name], ['is_active' => true]);
        }

        foreach ($services as $name) {
            Service::query()->updateOrCreate(['name' => $name], ['is_active' => true]);
        }
    }
}
