<?php

namespace App\Managers;

use PDO;
use App\Models\PlayerModel;
use App\Models\TeamModel;
use App\Models\MediaModel;

class PlayerManager extends AbstractManager
{
   public function getRandomPlayers(int $limit = 3): array
{
    $query = $this->db->prepare("
        SELECT players.*, 
               media.url AS portrait_url, 
               media.alt AS portrait_alt, 
               teams.id AS team_id,
               teams.name AS team_name, 
               teams.description AS team_description, 
               team_media.url AS team_logo_url,
               team_media.alt AS team_logo_alt
        FROM players
        JOIN media ON players.portrait = media.id
        JOIN teams ON players.team = teams.id
        JOIN media AS team_media ON teams.logo = team_media.id
        ORDER BY RAND()
        LIMIT :limit
    ");
    
    $query->bindValue(':limit', $limit, PDO::PARAM_INT);
    $query->execute();

    $players = [];
    while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
        // Création des objets MediaModel et TeamModel
        $teamLogo = new MediaModel($data['team_logo_url'], $data['team_logo_alt']);
        $team = new TeamModel($data['team_name'], $data['team_description'], $teamLogo, $data['team_id']);
        $portrait = new MediaModel($data['portrait_url'], $data['portrait_alt']);
        
        // Construction du tableau avec les données nécessaires pour PlayerModel
        $playerData = [
            'id' => $data['id'],
            'nickname' => $data['nickname'],
            'bio' => $data['bio'],
            'portrait' => $portrait,
            'team' => $team
        ];

        // Création de PlayerModel avec le tableau de données
        $players[] = new PlayerModel($playerData);
    }

    return $players;
}

}
?>
