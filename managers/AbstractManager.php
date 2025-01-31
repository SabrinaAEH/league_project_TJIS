<?php

namespace App\Managers;

use PDO;
use App\Config\Database;

abstract class AbstractManager
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}
?>

