<?php

class PlayerModel 
{
    private ? int $id = null;

    public function __construct(private string $nickname, private string $bio, private Media $portrait, private Team $team)
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

    public function getPortrait(): Media
    {
        return $this->portrait;
    }

    public function setPortrait(Media $portrait): void
    {
        $this->portrait = $portrait;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): void
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