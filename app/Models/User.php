<?php

namespace App\Models;

use Faker\Factory as FakerFactory;


class User
{
    public $id;
    public $firstname;
    public $lastname;
    public $email;

    public function __construct(array $attributes = [])
    {
        $faker = FakerFactory::create();

        $this->id = $attributes['id'] ?? $faker->randomNumber();
        $this->firstname = $attributes['firstname'] ?? $faker->firstName;
        $this->lastname = $attributes['lastname'] ?? $faker->lastName;
        $this->email = $attributes['email'] ?? $faker->email;
    }

    public static function getById(?int $id = null): User
    {
        if ($id !== null) {
            return new self(['id' => $id]);
        } else {
            return new self();
        }
    }
}
