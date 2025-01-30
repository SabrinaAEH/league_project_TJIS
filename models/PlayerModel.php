<?php

class PlayerModel 
{
    private ? int $id = null;

    public function __construct(private string $nickname, private string $bio, private MediaModel $portrait, private TeamModel $team)
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function getBio(): string
    {
        return $this->bio;
    }

    public function setBio(string $bio): void
    {
        $this->bio = $bio;
    }

    public function getPortrait(): MediaModel
    {
        return $this->portrait;
    }

    public function setPortrait(MediaModel $portrait): void
    {
        $this->portrait = $portrait;
    }

    public function getTeam(): TeamModel
    {
        return $this->team;
    }

    public function setTeam(TeamModel $team): void
    {
        $this->team = $team;
    }
    
    private array $performances = [];

    public function getPerformances(): array
    {
        return $this->performances;
    }
    
    public function setPerformances(array $performances): void
    {
        $this->performances = $performances;
    }
    
    public function addPerformance(PlayerPerformanceModel $performance): void
    {
        $this->performances[] = $performance;
    }
}