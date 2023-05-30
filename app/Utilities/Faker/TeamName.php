<?php

namespace App\Utilities\Faker;

/*
    Author: Github user marcelotk15 (from marcelotk15/faker-team)
    Licensed under terms of WTFPL
    * package not maintained, could not composer install due to requiring old version of php,
 */

class TeamName extends \Faker\Provider\Base
{
    protected static $animals = ['Hawks', 'Honeybadgers', 'Mantis Shrimps', 'Anteaters', 'Panthers', 'Wolves', 'Lions', 'Eagles', 'Wolverines', 'Gators', 'Scorpions', 'Monkeys', 'Weasels'];

    protected static $colors = ['Red', 'Black', 'Silver', 'Magenta', 'Green', 'Blue', 'White', 'Fuschia'];

    protected static $adjectives = ['Angry', 'Awesome', 'Mighty', 'Atomic', 'Screaming', 'Scorching', 'Slick', 'Big', 'Giant', 'Speedy', 'Red Hot', "Lil'", "Rockin'", 'Extreme'];

    protected static $disasters = ['Tornados', 'Hurricanes', 'Lightning', 'Thunder', 'Backdraft', 'Fire', 'Firestorms', 'Flames'];

    protected static $weapons = ['Bazookas', 'Machetes', 'Machine Guns', 'Daggers', 'Rockets'];

    protected static $others = ['Slayers', 'Bombers', 'Demons', 'Angels', 'X-treme', 'Maniacs', 'Annihilators', 'Rage', 'Bruisers'];

    protected static $namesFormats = [
        '{{color}} {{animal}}',
        '{{adjective}} {{animal}}',
        '{{adjective}} {{color}} {{animal}}',
        '{{color}} {{other}}',
        '{{adjective}} {{other}}',
        '{{adjective}} {{color}} {{other}}',
        '{{color}} {{disaster}}',
        '{{adjective}} {{disaster}}',
        '{{color}} {{weapon}}',
        '{{adjective}} {{weapon}}',
    ];

    public static function animal()
    {
        return static::randomElement(static::$animals);
    }

    public static function color()
    {
        return static::randomElement(static::$colors);
    }

    public static function adjective()
    {
        return static::randomElement(static::$adjectives);
    }

    public static function disaster()
    {
        return static::randomElement(static::$disasters);
    }

    public static function weapon()
    {
        return static::randomElement(static::$weapons);
    }

    public static function other()
    {
        return static::randomElement(static::$others);
    }

    public function teamName()
    {
        return $this->generator->parse(static::randomElement(static::$namesFormats));
    }
}