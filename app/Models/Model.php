<?php

namespace App\Models;

use App\Database\Database;
use PDO;

abstract class Model
{
    protected PDO $database;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }
}