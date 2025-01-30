<?php
use Config\Database;
class TeamManager extends AbstractManager {
    public function __construct() {
        parent::__construct();
    }

    public function findFeaturedTeam(): ?TeamModel {
        $query = $this->db->prepare('
            SELECT 
                t.id, t.name, t.description, 
                m.url AS logo_url, m.alt AS logo_alt
            FROM 
                teams t
            JOIN 
                media m ON t.logo = m.id
            WHERE 
                t.name = :name
        ');
        
        $query->bindValue(':name', 'Angry Owls');
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

    // Autres méthodes potentielles
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
