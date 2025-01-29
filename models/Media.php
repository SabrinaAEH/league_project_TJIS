<?php

class Media {
    // Propriétés correspondant à la structure de la table media
    private ?int $id;
    private string $url;
    private string $alt;

    // Constructeur
    public function __construct(string $url, string $alt, ?int $id) {
        $this->url = $url;
        $this->alt = $alt;
        $this->id = $id;
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getAlt(): string {
        return $this->alt;
    }

    // Setters
    public function setId(int $id): void {
        $this->id = $id;
    }
    public function setUrl(string $url): void {
        $this->url = $url;
    }

    public function setAlt(string $alt): void {
        $this->alt = $alt;
    }

    // Méthode de validation
    public function validate(): bool {
        return !empty($this->url) && !empty($this->alt);
    }
}