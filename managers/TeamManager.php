<?php
use Config\Database;
class TeamManager extends AbstractManager {
    public function __construct() {
        parent::__construct();
    }

    public function findFeaturedTeam(): ?TeamModel {
        $query = $this->db->prepare('
            SELECT 
            teams.id AS team_id, 
            teams.name AS team_name, 
            teams.description AS team_description, 
            media.url AS media_logo_url, 
            media.alt AS media_logo_alt
        FROM 
            teams 
        JOIN 
            media ON teams.logo = media.id
        WHERE 
            teams.name = :team_name
    ');
    
    $query->bindValue(':team_name', 'Angry Owls');
    $query->execute();
    
        $data = $query->fetch(\PDO::FETCH_ASSOC);
        
        if (!$data) {
            return null;
        }

        $logo = new MediaModel(
            $data['logo_url'], 
            $data['logo_alt'], 
            null
        );

        return new TeamModel(
            $data['name'], 
            $data['description'], 
            $logo, 
            $data['id']
        );
    }

    
    public function findAll(): array {
        $query = $this->db->query('SELECT * FROM teams');
        $teams = [];
        
        while ($data = $query->fetch(\PDO::FETCH_ASSOC)) {
            $logo = new MediaModel(
                '', // URL du logo 
                '', // Alt du logo
                $data['logo'] // ID du logo
            );

            $teams[] = new TeamModel(
                $data['name'], 
                $data['description'], 
                $logo, 
                $data['id']
            );
        }
        
        return $teams;
    }
}
