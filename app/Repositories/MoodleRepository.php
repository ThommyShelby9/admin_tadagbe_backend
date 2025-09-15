<?php

namespace App\Repositories;

use MrAtiebatie\Repository;
use App\Your\Model; // Don't forget to update the model's namespace

class MoodleRepository
{
    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Don't forget to update the model's name
        $this->model = app(Model::class);
    }
}
