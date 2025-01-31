<?php
namespace App\Managers;

use PDO;
use App\Models\GameModel;
use App\Models\TeamModel;
use App\Models\MediaModel; // Assurez-vous d'inclure le bon namespace

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

        if ($result) {
            $team1 = $this->getTeamModel($result['team_1']);
            $team2 = $this->getTeamModel($result['team_2']);
            $winner = $this->getTeamModel($result['winner']);
            return new GameModel(
                $result['id'],
                $result['name'],
                new \DateTime($result['date']),
                $team1,
                $team2,
                $winner
            );
        }

        return null;
    }

    public function findLastGame(): ?GameModel
    {
        $query = $this->db->query("SELECT * FROM games ORDER BY date DESC LIMIT 1");
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $team1 = $this->getTeamModel($result['team_1']);
            $team2 = $this->getTeamModel($result['team_2']);
            $winner = $this->getTeamModel($result['winner']);
            return new GameModel(
                $result['id'],
                $result['name'],
                new \DateTime($result['date']),
                $team1,
                $team2,
                $winner
            );
        }

        return null;
    }

    private function getTeamModel(int $teamId): TeamModel
    {
        $query = $this->db->prepare("SELECT * FROM teams WHERE id = :id");
        $query->bindValue(":id", $teamId, PDO::PARAM_INT);
        $query->execute();
        $teamData = $query->fetch(PDO::FETCH_ASSOC);

        // Créez un objet MediaModel pour le logo
        $logo = new MediaModel($teamData['logo'], $teamData['name']); // Assurez-vous que le nom est le bon attribut pour l'alt

        // Créez et retournez un objet TeamModel
        return new TeamModel(
            $teamData['name'],
            $teamData['description'],
            $logo, // Le logo est maintenant un objet MediaModel
            $teamData['id']
        );
    }
}
