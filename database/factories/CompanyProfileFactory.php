<?php

namespace Database\Factories;

use App\Models\Industry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyProfile>
 */
class CompanyProfileFactory extends Factory
{
    private static array $saudiCompanies = [
        ['name' => 'شركة الوطنية للأغذية', 'brand' => 'الوطنية'],
        ['name' => 'مجموعة الراجحي القابضة', 'brand' => 'الراجحي'],
        ['name' => 'شركة النهدي للتجارة', 'brand' => 'النهدي'],
        ['name' => 'مؤسسة الجميح للسيارات', 'brand' => 'الجميح'],
        ['name' => 'شركة المراعي', 'brand' => 'المراعي'],
        ['name' => 'شركة كيان السعودية', 'brand' => 'كيان'],
        ['name' => 'مجموعة بن لادن القابضة', 'brand' => 'بن لادن'],
        ['name' => 'شركة زين السعودية', 'brand' => 'زين'],
        ['name' => 'شركة جرير للتسويق', 'brand' => 'جرير'],
        ['name' => 'شركة البلاد للاستثمار', 'brand' => 'البلاد'],
    ];

    private static array $saudiNames = [
        'عبدالله المطيري',
        'فهد القحطاني',
        'خالد الشمري',
        'محمد الحربي',
        'أحمد الدوسري',
    ];

    private static array $cities = ['الرياض', 'جدة', 'الدمام', 'مكة المكرمة', 'الخبر'];

    private static int $companyIndex = 0;

    public function definition(): array
    {
        $company = self::$saudiCompanies[self::$companyIndex % count(self::$saudiCompanies)];
        self::$companyIndex++;

        return [
            'user_id' => User::factory()->company(),
            'company_name' => $company['name'],
            'brand_name' => $company['brand'],
            'contact_person' => fake()->randomElement(self::$saudiNames),
            'email' => fake()->safeEmail(),
            'phone' => fake()->numerify('05########'),
            'website' => fake()->optional()->url(),
            'industry_id' => Industry::factory(),
            'city' => fake()->randomElement(self::$cities),
            'country' => 'المملكة العربية السعودية',
            'description' => fake()->randomElement([
                'شركة سعودية رائدة متخصصة في مجال الأغذية والمشروبات، تقدم منتجات عالية الجودة للسوق المحلي والإقليمي.',
                'مؤسسة سعودية متنوعة الأنشطة تعمل في قطاعات التجزئة والعقارات والتقنية، مع سجل حافل بالإنجازات.',
                'شركة تقنية سعودية ناشئة تقدم حلولاً مبتكرة في مجال التحول الرقمي وخدمات التجارة الإلكترونية.',
                'مجموعة استثمارية سعودية تدير محفظة متنوعة من الأعمال في قطاعات الصحة والتعليم والترفيه.',
                'شركة سعودية متخصصة في التسويق الرقمي والحلول البرمجية، تخدم أكثر من 500 عميل في المنطقة.',
            ]),
            'is_complete' => true,
        ];
    }
}
