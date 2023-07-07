<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            PriceLevelSeeder::class,
            IndicatorSeeder::class,
            CountrySeeder::class,
            GroupSeeder::class,
            TagSeeder::class,
            OfSeeder::class,
            ClassroomSeeder::class,
            UserSeeder::class,
            TrainerSeeder::class,
            PromotionSeeder::class,
            QuizSeeder::class,
            NavBarSeeder::class,
            CourseSeeder::class,
            SessionSeeder::class,
            CompanySeeder::class,
            EnrollmentSeeder::class,
        ]);
    }
}
