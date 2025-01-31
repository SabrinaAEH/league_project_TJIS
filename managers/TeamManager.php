<?php

namespace App\Managers;

use PDO;
use App\Models\TeamModel;
use App\Models\MediaModel;

class TeamManager extends AbstractManager
{
    public function findFeaturedTeam(): ?TeamModel
    {
        $query = $this->db->prepare("
            SELECT teams.id, teams.name, teams.description, media.url AS logo_url, media.alt AS logo_alt
            FROM teams
            JOIN media ON teams.logo = media.id
            WHERE teams.name = :team_name
        ");

        $query->bindValue(':team_name', 'Angry Owls', PDO::PARAM_STR);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        return new TeamModel($data['name'], $data['description'], new MediaModel($data['logo_url'], $data['logo_alt']), $data['id']);
    }

    public function findAll(): array
    {
        $query = $this->db->query('SELECT * FROM teams');
        $teams = [];

        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $teams[] = new TeamModel($data['name'], $data['description'], new MediaModel("", ""), $data['id']);
        }

        return $teams;
    }
}
?>
