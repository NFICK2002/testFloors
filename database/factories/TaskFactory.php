<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = ['К выполнению','Выполняется','Выполнена','Отменена'];
        $priority = ['Высокий','Средний','Низкий'];
        return [
            'title' => $this->faker->text(12),
            'description' => $this->faker->text(50),
            'date_end' => $this->faker->dateTimeThisYear()->format('Y-m-d'),
            'priority' => $this->faker->randomElement($priority),
            'status' => $this->faker->randomElement($status),
            'creator_id' => $this->faker->randomElement(User::all()),
            'responsible_id' => $this->faker->randomElement(User::all()),
        ];
    }
}
