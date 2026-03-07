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
            'Social Media Marketing',
            'Influencer Campaigns',
            'Performance Ads',
            'Brand Awareness',
            'Lead Generation',
            'Content Production',
        ];

        $industries = [
            'Retail',
            'Food and Beverage',
            'E-commerce',
            'Education',
            'Healthcare',
            'Real Estate',
            'Fintech',
            'Travel and Tourism',
        ];

        $services = [
            'Social Media Management',
            'Paid Advertising',
            'Creative Design',
            'Content Writing',
            'Video Production',
            'SEO',
            'Marketing Strategy',
            'Influencer Management',
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
