<?php

namespace Database\Factories;

use App\Models\Mecc;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'mecc_id' =>  Mecc::all()->random()->id,
            'name' => $this->faker->words(4, true),
            'teacher' => $this->faker->name(),
            'grade_type' => $this->faker->randomElement(['Ecrit', 'Oral', 'Rapport', 'TP Test']),
            'exam_type' => $this->faker->randomElement(['Note intermédiaire', 'Moyenne de notes']),
            'exam_date' => $this->faker->dateTimeBetween('-10 weeks', '+3 weeks'),
        ];
    }
}
