<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    private static array $saudiMaleNames = [
        'عبدالله الغامدي',
        'فهد الشمري',
        'سلطان العتيبي',
        'خالد القحطاني',
        'محمد الحربي',
        'سعد الدوسري',
        'أحمد الزهراني',
        'عمر المالكي',
        'ياسر الشهري',
        'تركي العنزي',
        'بندر المطيري',
        'ماجد السبيعي',
        'نايف الرشيدي',
        'فيصل الجهني',
        'عبدالرحمن البلوي',
        'مشاري الحارثي',
        'وليد الثبيتي',
        'هشام العمري',
        'إبراهيم الأحمدي',
        'حمد السلمي',
    ];

    private static array $saudiCities = [
        'الرياض',
        'جدة',
        'الدمام',
        'مكة المكرمة',
        'المدينة المنورة',
        'الخبر',
        'تبوك',
        'أبها',
        'الطائف',
        'بريدة',
    ];

    private static int $nameIndex = 0;

    public function definition(): array
    {
        $name = self::$saudiMaleNames[self::$nameIndex % count(self::$saudiMaleNames)];
        self::$nameIndex++;

        $city = fake()->randomElement(self::$saudiCities);

        return [
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'role' => fake()->randomElement([Role::Company, Role::Agency]),
            'status' => UserStatus::Active,
            'phone' => fake()->numerify('05########'),
            'city' => $city,
            'country' => 'المملكة العربية السعودية',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => Role::Admin,
            'status' => UserStatus::Active,
        ]);
    }

    public function company(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => Role::Company,
            'status' => UserStatus::Active,
        ]);
    }

    public function agency(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => Role::Agency,
            'status' => UserStatus::Active,
        ]);
    }
}
