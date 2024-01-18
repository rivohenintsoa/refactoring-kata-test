<?php

namespace App\Models;

use Faker\Factory as FakerFactory;

class Template
{
    public $id;
    public $subject;
    public $content;

    public function __construct(array $attributes = [])
    {
        $faker = FakerFactory::create();

        $this->id = $attributes['id'] ?? $faker->randomNumber();
        $this->subject = $attributes['subject'] ?? $faker->sentence;
        $this->content = $attributes['content'] ?? $faker->paragraph;
    }

    public static function getById(?int $id = null): Template
    {
        if ($id !== null) {
            return new self(['id' => $id]);
        } else {
            return new self();
        }
    }
}