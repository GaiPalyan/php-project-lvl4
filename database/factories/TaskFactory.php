<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'status_id' => TaskStatus::factory(),
            'created_by_id' => User::factory(),
            'assigned_to_id' => User::factory()
        ];
    }
}
