<?php

namespace App\Models;

use Faker\Factory as FakerFactory;


class Site
{
    public $id;
    public $url;

    public function __construct(array $attributes = [])
    {
        $faker = FakerFactory::create();

        $this->id = $attributes['id'] ?? $faker->randomNumber();
        $this->url = $attributes['url'] ?? $faker->url;
    }

    public static function getById(?int $id = null): Site
    {
        if ($id !== null) {
            return new self(['id' => $id]);
        } else {
            return new self();
        }
    }
}