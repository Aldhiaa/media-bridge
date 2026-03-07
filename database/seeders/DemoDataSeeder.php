<?php

namespace Database\Seeders;

use App\Enums\CampaignStatus;
use App\Enums\ProposalStatus;
use App\Enums\Role;
use App\Enums\UserStatus;
use App\Models\AgencyProfile;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Conversation;
use App\Models\Industry;
use App\Models\Message;
use App\Models\Proposal;
use App\Models\Report;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use App\Notifications\ProposalStatusNotification;
use App\Notifications\ProposalSubmittedNotification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // ===== المدير =====
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@mediabridge.test'],
            [
                'name' => 'عبدالعزيز الفهد',
                'password' => Hash::make('admin12345'),
                'role' => Role::Admin->value,
                'status' => UserStatus::Active->value,
                'phone' => '0500000001',
                'city' => 'الرياض',
                'country' => 'المملكة العربية السعودية',
                'email_verified_at' => now(),
            ]
        );

        $categories = Category::all();
        $industries = Industry::all();
        $services = Service::all();

        // ===== الشركات =====
        $primaryCompany = User::query()->updateOrCreate(
            ['email' => 'company1@mediabridge.test'],
            [
                'name' => 'سلطان العتيبي',
                'password' => Hash::make('company12345'),
                'role' => Role::Company->value,
                'status' => UserStatus::Active->value,
                'phone' => '0501234567',
                'city' => 'الرياض',
                'country' => 'المملكة العربية السعودية',
                'email_verified_at' => now(),
            ]
        );

        $companies = collect([$primaryCompany])->merge(
            User::factory()->count(4)->company()->create()
        );

        foreach ($companies as $company) {
            CompanyProfile::factory()->for($company, 'user')->create([
                'industry_id' => $industries->random()->id,
                'email' => $company->email,
                'phone' => $company->phone,
                'city' => $company->city,
                'country' => $company->country,
                'is_complete' => true,
            ]);
        }

        // ===== الوكالات =====
        $primaryAgency = User::query()->updateOrCreate(
            ['email' => 'agency1@mediabridge.test'],
            [
                'name' => 'نواف الشهري',
                'password' => Hash::make('agency12345'),
                'role' => Role::Agency->value,
                'status' => UserStatus::Active->value,
                'phone' => '0559876543',
                'city' => 'جدة',
                'country' => 'المملكة العربية السعودية',
                'email_verified_at' => now(),
            ]
        );

        $agencies = collect([$primaryAgency])->merge(
            User::factory()->count(9)->agency()->create()
        );

        foreach ($agencies as $agencyUser) {
            $profile = AgencyProfile::factory()->for($agencyUser, 'user')->create([
                'email' => $agencyUser->email,
                'phone' => $agencyUser->phone,
                'city' => $agencyUser->city,
                'country' => $agencyUser->country,
                'is_complete' => true,
                'is_verified' => $agencyUser->email === 'agency1@mediabridge.test' ? true : (bool) rand(0, 1),
            ]);

            $profile->services()->sync($services->random(rand(2, 4))->pluck('id')->all());
            $profile->industries()->sync($industries->random(rand(2, 3))->pluck('id')->all());
        }

        // ===== الحملات =====
        $campaigns = collect();
        for ($i = 1; $i <= 15; $i++) {
            $statusPool = [
                CampaignStatus::Published,
                CampaignStatus::ReceivingProposals,
                CampaignStatus::UnderReview,
                CampaignStatus::Draft,
            ];

            $status = $statusPool[array_rand($statusPool)];
            $deadline = now()->addDays(rand(4, 25));

            $campaign = Campaign::factory()->create([
                'company_id' => $companies->random()->id,
                'category_id' => $categories->random()->id,
                'industry_id' => $industries->random()->id,
                'status' => $status->value,
                'proposal_deadline' => $deadline,
                'published_at' => in_array($status, [CampaignStatus::Published, CampaignStatus::ReceivingProposals], true) ? now()->subDays(rand(1, 10)) : null,
                'is_featured' => $i <= 6,
            ]);

            $channelSamples = ['انستغرام', 'تيك توك', 'سناب شات', 'X (تويتر)', 'يوتيوب', 'إعلانات قوقل'];
            foreach (collect($channelSamples)->shuffle()->take(rand(2, 4)) as $channel) {
                $campaign->channels()->create(['channel' => $channel]);
            }

            if (rand(0, 1)) {
                $campaign->attachments()->create([
                    'uploaded_by' => $campaign->company_id,
                    'original_name' => 'ملخص-الحملة-' . $campaign->id . '.pdf',
                    'file_path' => 'campaigns/brief-' . $campaign->id . '.pdf',
                    'mime_type' => 'application/pdf',
                    'file_size' => rand(12000, 700000),
                ]);
            }

            $campaigns->push($campaign);
        }

        // ===== العروض =====
        $proposalTotal = 0;
        while ($proposalTotal < 30) {
            $campaign = $campaigns->random();
            $agency = $agencies->random();

            if (Proposal::query()->where('campaign_id', $campaign->id)->where('agency_id', $agency->id)->exists()) {
                continue;
            }

            $proposal = Proposal::factory()->create([
                'campaign_id' => $campaign->id,
                'agency_id' => $agency->id,
                'status' => ProposalStatus::Submitted->value,
                'submitted_at' => now()->subDays(rand(1, 8)),
            ]);

            if (rand(0, 1)) {
                $proposal->attachments()->create([
                    'original_name' => 'عرض-تقديمي-' . $proposal->id . '.pdf',
                    'file_path' => 'proposals/proposal-' . $proposal->id . '.pdf',
                    'mime_type' => 'application/pdf',
                    'file_size' => rand(9000, 500000),
                ]);
            }

            $proposalTotal++;
        }

        // ===== ترسية وإكمال بعض الحملات =====
        $reviewComments = [
            'تنفيذ ممتاز وتواصل احترافي طوال فترة المشروع. ننصح بالتعامل معهم.',
            'جودة عالية في المحتوى والتصميم. التزام تام بالمواعيد والميزانية.',
            'فريق محترف وخبرة واضحة في السوق السعودي. نتائج فاقت توقعاتنا.',
            'تجربة ممتازة من البداية للنهاية. تقارير أداء دقيقة وشفافة.',
            'عمل رائع وإبداع في المحتوى. سنتعامل معهم مرة أخرى بالتأكيد.',
        ];

        $campaignsWithProposals = Campaign::query()->has('proposals', '>=', 2)->get();
        foreach ($campaignsWithProposals->shuffle()->take(5) as $campaign) {
            $accepted = $campaign->proposals()->inRandomOrder()->first();
            if (!$accepted) {
                continue;
            }

            $accepted->update([
                'status' => ProposalStatus::Accepted->value,
                'accepted_at' => now()->subDays(rand(1, 4)),
            ]);

            Proposal::query()
                ->where('campaign_id', $campaign->id)
                ->where('id', '!=', $accepted->id)
                ->update([
                    'status' => ProposalStatus::Rejected->value,
                    'rejected_at' => now()->subDays(rand(1, 3)),
                ]);

            $campaign->update([
                'status' => collect([
                    CampaignStatus::Awarded,
                    CampaignStatus::InProgress,
                    CampaignStatus::Completed,
                ])->random()->value,
            ]);

            if ($campaign->status === CampaignStatus::Completed) {
                Review::query()->create([
                    'campaign_id' => $campaign->id,
                    'proposal_id' => $accepted->id,
                    'company_id' => $campaign->company_id,
                    'agency_id' => $accepted->agency_id,
                    'rating' => rand(4, 5),
                    'comment' => $reviewComments[array_rand($reviewComments)],
                    'is_approved' => true,
                ]);
            }
        }

        // ===== المحادثات =====
        $chatMessages = [
            'السلام عليكم، نود الاستفسار عن تفاصيل العرض المقدم.',
            'وعليكم السلام، بالتأكيد. نحن جاهزون للإجابة على أي استفسار.',
            'هل يمكنكم تقديم عرض مخصص لحملة رمضان؟',
            'نعم بكل تأكيد. سنرسل لكم عرضاً مفصلاً خلال 24 ساعة.',
            'ما هي المنصات التي تنصحون بها لمنتجنا؟',
            'بناءً على تحليل الجمهور المستهدف، ننصح بسناب شات وانستغرام.',
            'متى يمكنكم البدء في تنفيذ الحملة؟',
            'يمكننا البدء خلال أسبوع من الموافقة على العرض.',
            'هل لديكم أعمال سابقة في نفس القطاع؟',
            'نعم، نفذنا 3 حملات مشابهة مؤخراً. سنشارككم الملفات.',
            'ممتاز، نتطلع للتعاون معكم.',
            'شكراً لثقتكم. سنبذل قصارى جهدنا لتحقيق أفضل النتائج.',
        ];

        $proposalsForConversations = Proposal::query()->with('campaign')->inRandomOrder()->take(20)->get();
        foreach ($proposalsForConversations as $proposal) {
            $conversation = Conversation::query()->firstOrCreate(
                [
                    'campaign_id' => $proposal->campaign_id,
                    'company_id' => $proposal->campaign->company_id,
                    'agency_id' => $proposal->agency_id,
                ],
                [
                    'proposal_id' => $proposal->id,
                    'last_message_at' => now(),
                ]
            );

            $messageCount = rand(1, 4);
            for ($i = 0; $i < $messageCount; $i++) {
                $senderId = $i % 2 === 0 ? $conversation->company_id : $conversation->agency_id;
                $message = Message::query()->create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => $senderId,
                    'body' => $chatMessages[array_rand($chatMessages)],
                    'is_read' => rand(0, 1) === 1,
                    'read_at' => now(),
                    'created_at' => now()->subHours(rand(1, 72)),
                    'updated_at' => now()->subHours(rand(1, 72)),
                ]);

                $conversation->update(['last_message_at' => $message->created_at]);
            }
        }

        // ===== الإشعارات =====
        Proposal::query()->with(['campaign.company', 'agency'])->latest()->take(12)->get()->each(function (Proposal $proposal): void {
            $proposal->campaign->company->notify(new ProposalSubmittedNotification($proposal));
            $proposal->agency->notify(new ProposalStatusNotification($proposal, $proposal->status->label()));
        });

        Conversation::query()->with(['company', 'agency'])->latest()->take(8)->get()->each(function (Conversation $conversation): void {
            $conversation->agency->notify(new NewMessageNotification($conversation, $conversation->company));
        });

        // ===== البلاغات =====
        $reportSubjects = [
            'تأخر في التسليم',
            'جودة المحتوى غير مقبولة',
            'عدم الالتزام بالاتفاق',
            'محتوى مخالف للسياسات',
            'تواصل غير احترافي',
            'ادعاءات غير صحيحة في الملف التعريفي',
            'عدم الرد على الرسائل',
            'طلب دفعات خارج المنصة',
            'إساءة استخدام المنصة',
            'بيانات مضللة في العرض',
        ];

        $reportDetails = [
            'تم رصد تأخر متكرر في تسليم المخرجات المتفق عليها دون إبداء أسباب واضحة أو التواصل المسبق.',
            'المحتوى المقدم لا يرقى للمستوى المتفق عليه ولا يتوافق مع المعايير المذكورة في العرض.',
            'لم يتم الالتزام بالشروط والأحكام المتفق عليها في العقد المبرم عبر المنصة.',
            'تم نشر محتوى يخالف سياسات المنصة ومعايير الإعلان في المملكة العربية السعودية.',
            'أسلوب التواصل غير احترافي ولا يتناسب مع بيئة العمل المهنية.',
        ];

        $reportTypes = ['مستخدم', 'حملة', 'عرض'];

        $allUsers = User::query()->where('role', '!=', Role::Admin->value)->get();
        for ($i = 0; $i < 10; $i++) {
            $reporter = $allUsers->random();
            $reported = $allUsers->where('id', '!=', $reporter->id)->random();
            $campaign = $campaigns->random();

            Report::query()->create([
                'reporter_id' => $reporter->id,
                'reported_user_id' => $reported->id,
                'campaign_id' => $campaign->id,
                'proposal_id' => $campaign->proposals()->inRandomOrder()->value('id'),
                'type' => collect(['user', 'campaign', 'proposal'])->random(),
                'subject' => $reportSubjects[$i],
                'details' => $reportDetails[array_rand($reportDetails)],
                'status' => collect(['open', 'under_review', 'resolved'])->random(),
                'resolved_by' => $admin->id,
                'resolved_at' => now()->subDays(rand(0, 5)),
            ]);
        }
    }
}
