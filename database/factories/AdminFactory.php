<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
            return [

                'first_name'=>'Ermias',
                'last_name'=>'Alem',
                'password'=> Hash::make('1234'),
                'role_id'=>1,
                'email'=>'alemteb1010@gmail.com',

        ];
    }
}
