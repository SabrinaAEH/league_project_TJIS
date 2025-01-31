<?php

namespace App\Managers;

use PDO;
use App\Models\PlayerModel;
use App\Models\TeamModel;
use App\Models\MediaModel;
use App\Models\PlayerPerformance;

class PlayerPerformanceManager extends AbstractManager
{
    public function findPlayerById(int $id): ?PlayerModel
    {
        $query = $this->db->prepare("SELECT * FROM players WHERE id = :id");
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }

        return new PlayerModel($result["nickname"], $result["bio"], new MediaModel(""), null, $result["id"]);
    }

    public function findPlayerPerformance(int $playerId): array
    {
        $query = $this->db->prepare("
            SELECT *
            FROM player_performance
            WHERE player = :playerId
        ");

        $query->bindValue(':playerId', $playerId, PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $performances = [];
        foreach ($results as $result) {
            $performance = new PlayerPerformance(
                $result["player"], 
                $result["game"], 
                $result["points"], 
                $result["assists"],
                $result["id"]
            );
            $performances[] = $performance; 
        }

        return $performances;
    }

    public function findPlayerTeam(int $playerId): ?TeamModel
    {
        $query = $this->db->prepare("
            SELECT teams.*
            FROM players
            JOIN teams ON players.team = teams.id
            WHERE players.id = :playerId
        ");

        $query->bindValue(':playerId', $playerId, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        $teamLogo = new MediaModel($result["logo"], ""); 
        return new TeamModel($result["name"], $result["description"], $teamLogo, $result["id"]);
    }

    public function findPlayersInSameTeam(int $playerId): array
    {
        $team = $this->findPlayerTeam($playerId);
        if (!$team) {
            return [];
        }

        $query = $this->db->prepare("
            SELECT p.*
            FROM players p
            WHERE p.team = :teamId
            AND p.id != :playerId
        ");

        $query->bindValue(":teamId", $team->getId(), PDO::PARAM_INT);
        $query->bindValue(":playerId", $playerId, PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $players = [];
        foreach ($results as $result) {
            $players[] = new PlayerModel(
                $result["nickname"],
                $result["bio"],
                new MediaModel(""),
                $team,
                $result["id"]
            );
        }

        return $players;
    }
}
?>
