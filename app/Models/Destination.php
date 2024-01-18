<?php

namespace App\Models;

use Faker\Factory as FakerFactory;

class Destination
{
    public $id;
    public $countryName;
    public $conjunction;
    public $name;
    public $computerName;

    public function __construct(array $attributes = [])
    {
        $faker = FakerFactory::create();

        $this->id = $attributes['id'] ?? null;
        $this->countryName = $attributes['countryName'] ?? $faker->country;
        $this->conjunction = $attributes['conjunction'] ?? $faker->randomElement(['in', 'at', 'on']);
        $this->computerName = $attributes['computerName'] ?? $faker->word();
    }

    /**
     * Get an instance by ID or create a new one with Faker.
     *
     * @param int|null $id
     * 
     * @return Destination
     */
    public static function getById(?int $id = null): Destination
    {
        if ($id !== null) {
            return new self(['id' => $id, 'conjunction' => 'en']);
        } else {
            return new self();
        }
    }
}
