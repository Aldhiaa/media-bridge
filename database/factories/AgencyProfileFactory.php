<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AgencyProfile>
 */
class AgencyProfileFactory extends Factory
{
    private static array $saudiAgencies = [
        ['name' => 'وكالة إبداع ميديا', 'about' => 'وكالة تسويق رقمي سعودية متخصصة في إدارة حملات السوشيال ميديا وإنتاج المحتوى الإبداعي. نخدم أكثر من 100 علامة تجارية في المملكة.'],
        ['name' => 'وكالة رقم للتسويق', 'about' => 'وكالة رائدة في الإعلانات المدفوعة والتسويق عبر منصات التواصل الاجتماعي، مع فريق متخصص في تحليل البيانات وتحسين الأداء.'],
        ['name' => 'شركة نقطة للحلول الرقمية', 'about' => 'نقدم حلولاً متكاملة في التسويق الرقمي من التخطيط الاستراتيجي إلى التنفيذ والقياس. خبرة 8 سنوات في السوق السعودي.'],
        ['name' => 'وكالة مسار الإعلامية', 'about' => 'متخصصون في حملات المؤثرين وإنتاج الفيديو القصير. نعمل مع أبرز المؤثرين في المملكة ودول الخليج.'],
        ['name' => 'مؤسسة صدى للتسويق الرقمي', 'about' => 'وكالة تسويق رقمي متكاملة تقدم خدمات إدارة الحملات الإعلانية وكتابة المحتوى والتصميم الجرافيكي.'],
        ['name' => 'وكالة بيكسل كريتف', 'about' => 'وكالة إبداعية متخصصة في التصميم والهوية البصرية وإنتاج المحتوى المرئي عالي الجودة للعلامات التجارية.'],
        ['name' => 'شركة ذا ديجيتال للتسويق', 'about' => 'شركة تسويق رقمي متخصصة في إعلانات Google وSEO وتحسين معدلات التحويل. حققنا نتائج مميزة لأكثر من 200 عميل.'],
        ['name' => 'وكالة تريند للإعلام', 'about' => 'وكالة إعلامية سعودية تركز على تسويق المحتوى والعلاقات العامة الرقمية. فريقنا يضم خبراء في صناعة المحتوى العربي.'],
        ['name' => 'مؤسسة كود للحلول الرقمية', 'about' => 'متخصصون في التسويق عبر البريد الإلكتروني وأنظمة إدارة العملاء (CRM) والأتمتة التسويقية.'],
        ['name' => 'وكالة ستوري ميديا', 'about' => 'وكالة متخصصة في إنتاج الفيديو والبودكاست والمحتوى الطويل. نتميز بقصص تسويقية تلامس الجمهور السعودي.'],
    ];

    private static array $saudiNames = [
        'سعد العتيبي',
        'نواف الشهري',
        'مشاري الحارثي',
        'تركي البلوي',
        'عمر الجهني',
        'بندر الرشيدي',
        'فيصل الأحمدي',
        'ياسر المالكي',
        'ماجد الزهراني',
        'وليد السلمي',
    ];

    private static array $cities = ['الرياض', 'جدة', 'الدمام', 'الخبر', 'المدينة المنورة'];

    private static int $agencyIndex = 0;

    public function definition(): array
    {
        $agency = self::$saudiAgencies[self::$agencyIndex % count(self::$saudiAgencies)];
        self::$agencyIndex++;

        return [
            'user_id' => User::factory()->agency(),
            'agency_name' => $agency['name'],
            'contact_person' => fake()->randomElement(self::$saudiNames),
            'email' => fake()->safeEmail(),
            'phone' => fake()->numerify('05########'),
            'website' => fake()->optional()->url(),
            'city' => fake()->randomElement(self::$cities),
            'country' => 'المملكة العربية السعودية',
            'about' => $agency['about'],
            'years_experience' => fake()->numberBetween(2, 12),
            'portfolio_links' => [fake()->url(), fake()->url()],
            'minimum_budget' => fake()->randomElement([2000, 3000, 5000, 8000, 10000]),
            'team_size' => fake()->randomElement(['3-5', '6-10', '11-20', '21-50']),
            'pricing_style' => fake()->randomElement(['بالمشروع', 'شهري', 'حسب الأداء', 'باقات ثابتة']),
            'is_complete' => true,
            'is_verified' => fake()->boolean(40),
        ];
    }
}
