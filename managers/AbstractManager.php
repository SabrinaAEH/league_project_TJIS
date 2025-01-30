<?php

namespace App\Managers;

use App\Config\Database;
use PDO;

abstract class AbstractManager
{
    protected PDO $db;

    public function __construct()
    {
        // Utilisation de la connexion unique de Database.php
        $this->db = Database::getInstance()->getConnection();
    }
}
