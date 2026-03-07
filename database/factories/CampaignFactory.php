<?php

namespace Database\Factories;

use App\Enums\CampaignStatus;
use App\Models\Category;
use App\Models\Industry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    private static array $campaignTitles = [
        'حملة إطلاق منتج جديد في السوق السعودي',
        'حملة تسويقية لخدمات التوصيل في الرياض',
        'حملة رمضان لزيادة المبيعات عبر الإنترنت',
        'حملة توعوية لتطبيق صحي جديد',
        'حملة إعلانية لمطعم في جدة',
        'حملة تسويق عقاري لمشروع سكني',
        'حملة انستغرام لعلامة أزياء سعودية',
        'حملة إعلانية لموسم الرياض',
        'حملة تيك توك لمنتجات التجميل',
        'حملة ترويجية لتطبيق توصيل طعام',
        'حملة إطلاق متجر إلكتروني جديد',
        'حملة Build Your Brand في منطقة الخليج',
        'حملة سناب شات لقطاع الترفيه',
        'حملة تسويقية لمنصة تعليمية سعودية',
        'حملة إعلانات أداء لمتجر إلكتروني',
    ];

    private static array $descriptions = [
        'نبحث عن وكالة تسويق رقمي متخصصة لإدارة حملة إطلاق منتجنا الجديد. نريد الوصول لأكبر شريحة من الجمهور المستهدف في المملكة العربية السعودية خلال فترة الإطلاق. الحملة تشمل إعلانات مدفوعة على منصات التواصل الاجتماعي وإنتاج محتوى ترويجي.',
        'نحتاج حملة تسويقية شاملة لزيادة الوعي بعلامتنا التجارية وتحقيق نمو في المبيعات عبر القنوات الرقمية. الحملة تستهدف الشباب السعودي (18-35 سنة) ونريد محتوى إبداعي يعكس الهوية السعودية.',
        'مطلوب وكالة لإدارة حملة إعلانية متكاملة على منصات التواصل الاجتماعي (سناب شات، تيك توك، انستغرام). نريد محتوى فيديو قصير جذاب مع التركيز على الجمهور السعودي والخليجي.',
        'نبحث عن شريك تسويقي لإدارة حملات المؤثرين لعلامتنا التجارية. نحتاج التعاون مع مؤثرين سعوديين في مجال الطعام والمشروبات مع تقارير أداء شهرية.',
        'حملة تسويقية لزيادة التحميلات والاشتراكات في تطبيقنا الجديد. نريد إعلانات أداء على قوقل وآبل مع تحسين معدل التحويل. الميزانية مرنة بناءً على النتائج.',
    ];

    private static array $audiences = [
        'الشباب السعودي من 18 إلى 35 سنة في المدن الرئيسية',
        'ربات البيوت والأمهات في المملكة (25-45 سنة)',
        'رجال الأعمال وأصحاب المشاريع الصغيرة في الخليج',
        'طلاب الجامعات في الرياض وجدة والدمام',
        'محبو التقنية والألعاب الإلكترونية (16-30 سنة)',
        'المهتمون بالصحة واللياقة البدنية في المملكة',
    ];

    private static array $deliverables = [
        'تصميم 20 بوست + 10 ستوري + 4 فيديو ريلز + تقرير أداء شهري',
        '15 إعلان مدفوع + إدارة حملات قوقل + تقارير أسبوعية',
        'محتوى يومي على 3 منصات + تصوير فيديو + موشن جرافيك',
        'إدارة حسابات سوشيال ميديا + حملة مؤثرين (5 مؤثرين) + تقارير',
        'تصميم هوية بصرية رقمية + 30 منشور + إعلانات مدفوعة + SEO',
    ];

    private static int $titleIndex = 0;

    public function definition(): array
    {
        $title = self::$campaignTitles[self::$titleIndex % count(self::$campaignTitles)];
        self::$titleIndex++;

        $proposalDeadline = fake()->dateTimeBetween('now', '+30 days');

        return [
            'company_id' => User::factory()->company(),
            'category_id' => Category::factory(),
            'industry_id' => Industry::factory(),
            'title' => $title,
            'objective' => fake()->randomElement([
                'زيادة الوعي بالعلامة التجارية',
                'رفع المبيعات',
                'توليد عملاء محتملين',
                'إطلاق منتج جديد',
                'زيادة المتابعين والتفاعل',
            ]),
            'description' => fake()->randomElement(self::$descriptions),
            'target_audience' => fake()->randomElement(self::$audiences),
            'required_deliverables' => fake()->randomElement(self::$deliverables),
            'budget' => fake()->randomElement([3000, 5000, 8000, 10000, 15000, 20000, 30000, 50000]),
            'start_date' => fake()->dateTimeBetween('+5 days', '+45 days'),
            'end_date' => fake()->dateTimeBetween('+46 days', '+90 days'),
            'proposal_deadline' => $proposalDeadline,
            'allow_proposal_updates' => true,
            'status' => fake()->randomElement([
                CampaignStatus::Published,
                CampaignStatus::ReceivingProposals,
                CampaignStatus::UnderReview,
            ]),
            'is_featured' => fake()->boolean(20),
            'published_at' => fake()->dateTimeBetween('-20 days', 'now'),
        ];
    }
}
