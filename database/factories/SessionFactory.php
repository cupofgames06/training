<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Session>
 */
class SessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $course = Course::where('type','!=','elearning')->get()->random();

        return [
            'course_id' => $course->id,
            'classroom_id' => Classroom::all()->pluck('id')->random(),
            'cost' => fake()->numberBetween(100, 3000),
            'status' => fake()->randomElement(Session::STATUS),
        ];
    }
}
