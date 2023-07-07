<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Company;
use App\Models\CompanyActivityLog;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Entity;
use App\Models\Indicator;
use App\Models\Learner;
use App\Models\LearnerDescription;
use App\Models\PriceLevel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Tags\Tag;

class CompanySeeder extends UserSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Company::factory()->count(1)->create()->each(function($item) {

            // création user avec role company
            $manager = User::factory()->create([
                'email'             => 'company@company.com',
                'password'          => Hash::make('company@company.com'),
                'email_verified_at' => Carbon::now()->toDateTimeString(),
            ]);

            $manager->assignRole('company');
            parent::addProfileInfos($manager);
            //$item->managers()->attach($company);


            $learner = Learner::factory()->create([
                'email'             => 'learner@learner.com',
                'password'          => Hash::make('learner@learner.com'),
                'email_verified_at' => Carbon::now()->toDateTimeString(),
            ]);
            parent::addProfileInfos($learner);
            $learner->assignRole('learner');
            $item->addUser($learner->id);
            self::addLearnerInfos($learner,$item);

            // création d'un nombre random d'apprenants par default dans une société
            Learner::factory()->count(fake()->numberBetween(0,50))->create()->each(function($learner,$key) use($item){
                parent::addProfileInfos($learner);
                $learner->assignRole('learner');
                $item->addUser($learner->id);
                self::addLearnerInfos($learner,$item);
                foreach (Indicator::all() as $indicator)
                {
                    $learner->addIndicatorCourse($indicator,Course::all()->random(),fake()->numberBetween(0, 100));
                }
            });

            Address::factory()->for(
                $item, 'addressable'
            )->create();
            Entity::factory()->for(
                $item, 'modelable'
            )->create();
            Contact::factory()->count(fake()->numberBetween(1,3))->for(
                $item, 'contactable'
            )->create();

            $item->addUser($manager->id);

        });

        Company::factory()->count(10)->create()->each(function($item){
            //Création manager associé à la société
            $manager = User::factory()->create();
            $manager->assignRole('company');
            parent::addProfileInfos($manager);


            // création d'un nombre random d'apprenants par default dans une société
            Learner::factory()->count(fake()->numberBetween(1,20))->create()->each(function($learner) use($item){
                parent::addProfileInfos($learner);
                $learner->assignRole('learner');
                $item->addUser($learner->id);
                self::addLearnerInfos($learner,$item);
            });

            Address::factory()->for(
                $item, 'addressable'
            )->create();
            Entity::factory()->for(
                $item, 'modelable'
            )->create();
            Contact::factory()->for(
                $item, 'contactable'
            )->create();

            $item->addUser($manager->id);
        });
    }
    protected function addLearnerInfos(User $user, Company $company): void
    {
        $start = fake()->dateTimeBetween('-2 years')->format('Y-m-d');
        $dummyInfo = [
            "learner_id" => $user->id,
            "company_id" => $company->id,
            "email" => fake()->email,
            "date_start" => $start,
            "date_end" => fake()->boolean() ?null:fake()->dateTimeBetween($start,'+2 years'),
            'job_title'  => Tag::where('type','function')->get()->pluck('id')->random(),
            'service' => Tag::where('type','service')->get()->pluck('id')->random()
        ];

        $info = new LearnerDescription();
        foreach ($dummyInfo as $key => $value) {
            $info->$key = $value;
        }
        $info->learner()->associate($user);
        $info->save();
    }
}
