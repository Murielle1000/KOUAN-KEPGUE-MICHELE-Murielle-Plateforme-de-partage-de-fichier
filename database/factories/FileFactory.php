<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'          => $this->faker->word(),
            'original_name' => $this->faker->word() . '.pdf',
            'path'          => 'uploads/fake-file.pdf',
            'mime_type'     => 'application/pdf',
            'size'          => $this->faker->numberBetween(1000, 5000000),
            'user_id'       => User::factory(),
            'folder_id'     => null,
            'is_public'     => false,
            'share_token'   => null,
        ];
    }
}