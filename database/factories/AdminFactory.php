<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->name,
            'no_hp' => $this->faker->phoneNumber,
            'alamat' => $this->faker->address,
            'user_id' => User::factory()
        ];
    }
}
