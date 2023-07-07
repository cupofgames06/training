<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Of;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'of_id' => Of::all()->pluck('id')->random(),
            'type' => Course::COURSE_TYPE[rand(0,count(Course::COURSE_TYPE)-1)],
            'duration' => fake()->numberBetween(0, 100),
            'status' => Course::STATUS[rand(0,count(Course::STATUS)-1)]
        ];
    }
}
