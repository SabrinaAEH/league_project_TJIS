<?php

namespace App\Managers;

use PDO;
use App\Models\GameModel;

class GameManager extends AbstractManager
{
    public function findAllGames(): array
    {
        $query = $this->db->query("SELECT * FROM games");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOneGame(int $id): ?GameModel
    {
        $query = $this->db->prepare("SELECT * FROM games WHERE id = :id");
        $query->bindValue(":id", $id, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? new GameModel($result) : null;
    }

    public function findLastGame(): ?GameModel
    {
        $query = $this->db->query("SELECT * FROM games ORDER BY date DESC LIMIT 1");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? new GameModel($result) : null;
    }
}
?>
