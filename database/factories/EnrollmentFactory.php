<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Learner;
use App\Models\Pack;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $enrollmentable = $this->enrollmentable();
        return [
            'enrollmentable_id' => $enrollmentable->id,
            'enrollmentable_type' => $enrollmentable->getMorphClass(),
            'user_id' => Learner::all()->pluck('id')->random(),
            'company_id' => Company::all()->pluck('id')->random(),
            'status' => fake()->randomElement(Enrollment::STATUS)
        ];
    }
    protected function enrollmentable()
    {
        $arr = Session::all()->concat(Course::where('type','elearning')->get())->concat(Pack::all());

        return fake()->randomElement($arr);
    }
}
