<?php

namespace Hadialharbi\NestedComments\Tests\Factories;

use Hadialharbi\NestedComments\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'body' => $this->faker->paragraph,
            'user_id' => 1, // أو null لو تختبر ضيوف
            'commentable_type' => 'App\\Models\\Post', // غرض وهمي للاختبار
            'commentable_id' => 1,
            'guest_id' => Str::uuid(),
            'guest_name' => $this->faker->name,
            'ip_address' => $this->faker->ipv4,
            'is_published' => true,
        ];
    }
}
