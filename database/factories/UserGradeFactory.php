<?php

namespace Database\Factories;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserGrade>
 */
class UserGradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'student_id' => 21901316,
            'grade_id' => Grade::factory(),
            'grade_value' => $this->faker->randomFloat(2, 0, 20),
        ];
    }
}
