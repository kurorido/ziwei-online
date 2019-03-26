<?php

namespace App\Domain;

class Temple
{
    public $name;
    public $time;
    public $primary_stars = [];
    public $secondary_stars = [];
    public $bad_stars = [];
    public $sky;

    public function __construct($time) {
        $this->time = $time;
    }
}