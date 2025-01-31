<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Managers\PlayerManager;
use App\Managers\TeamManager;
use App\Managers\GameManager;

class HomeController extends BaseController
{
    private PlayerManager $playerManager;
    private TeamManager $teamManager;
    private GameManager $gameManager;

    public function __construct(PlayerManager $playerManager, TeamManager $teamManager, GameManager $gameManager)
    {
        parent::__construct();
        $this->playerManager = $playerManager;
        $this->teamManager = $teamManager;
        $this->gameManager = $gameManager;
    }

    public function index()
    {
        // Récupérer 3 joueurs aléatoires depuis la base de données
        $players = $this->playerManager->getRandomPlayers(3);

        // Récupérer la team à la une
        $featuredTeam = $this->teamManager->findFeaturedTeam();

        // Récupérer les joueurs de l'équipe à la une
        $teamPlayers = [];
        if ($featuredTeam) {
            $teamPlayers = $this->playerManager->getPlayersByTeam($featuredTeam->getId());
        }

        // Récupérer le dernier match
        $lastGame = $this->gameManager->findLastGame();

        // Formatage de la date du dernier match si elle existe
        $lastGameFormattedDate = null;
        if ($lastGame) {
            $lastGameFormattedDate = $lastGame->getDate()->format('Y-m-d H:i:s');  // Format souhaité
        }

        // Rendu du template avec les données nécessaires
        echo $this->twig->render('home.twig', [
            'section_titles' => [
                'teams' => 'La team à la une',
                'players' => 'Les players à la une',
                'matches' => 'Le Dernier Match'
            ],
            'players' => $players,                  // 3 joueurs aléatoires
            'team_players' => $teamPlayers,         // Joueurs de l'équipe à la une
            'featured_team' => $featuredTeam,       // Information de l'équipe à la une
            'last_game' => $lastGame,               // Dernier match
            'last_game_formatted_date' => $lastGameFormattedDate // Date formatée du dernier match
        ]);
    }
}
