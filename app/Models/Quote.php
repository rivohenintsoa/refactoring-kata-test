<?php

namespace App\Models;

use Faker\Factory as FakerFactory;


class Quote
{
    public $id;
    public $siteId;
    public $destinationId;
    public $dateQuoted;

    public function __construct(array $attributes = [])
    {
        $faker = FakerFactory::create();

        $this->id = $attributes['id'] ?? $faker->randomNumber();
        $this->siteId = $attributes['siteId'] ?? $faker->randomNumber();
        $this->destinationId = $attributes['destinationId'] ?? $faker->randomNumber();
        $this->dateQuoted = $attributes['dateQuoted'] ?? $faker->dateTimeThisDecade->format('Y-m-d H:i:s');
    }

    public static function renderHtml(Quote $quote)
    {
        return '<p>' . $quote->id . '</p>';
    }

    public static function renderText(Quote $quote)
    {
        return (string) $quote->id;
    }

    public static function getById(?int $id = null): Quote
    {
        if ($id !== null) {
            return new self(['id' => $id, 'destinationId' => 1]);
        } else {
            return new self();
        }
    }
}