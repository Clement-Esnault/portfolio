<?php

class Entity {

    private int $id;
    private string $nom;
    private string $description;

    private int $pv;
    private int $pvMax;
    private int $mana;
    private int $manaMax;

    private int $strength;
    private int $initiative;
    private int $attack;
    private int $capacity;

    public function __construct(array $data) {
        $this->id = $data['ENT_ID'];
        $this->nom = $data['ENT_NOM'] ?? '';
        $this->description = $data['ENT_DESCRIPTION'] ?? '';

        $this->pv = $data['ENT_PV'] ?? 0;
        $this->pvMax = $data['ENT_PV_MAX'] ?? 0;

        $this->mana = $data['ENT_MANA'] ?? 0;
        $this->manaMax = $data['ENT_MANA_MAX'] ?? 0;

        $this->strength = $data['ENT_STRENGTH'] ?? 0;
        $this->initiative = $data['ENT_INITIATIVE'] ?? 0;
        $this->attack = $data['ENT_ATTACK'] ?? 0;
        $this->capacity = $data['ENT_CAPACITY'] ?? 0;
    }

    /* ===== COMBAT ===== */

    public function estVivant(): bool {
        return $this->pv > 0;
    }

    public function subirDegats(int $degats): void {
        $this->pv = max(0, $this->pv - $degats);
    }

    public function attaquePhysique(): int {
        return rand(1, 6) + $this->strength + $this->attack;
    }

    public function defense(): int {
        return rand(1, 6) + intdiv($this->strength, 2);
    }

    public function setPv(int $pv): void {
        $this->pv = $pv;
    }
    
    public function setMana(int $mana): void {
        $this->mana = $mana;
    }

    /* ===== GETTERS ===== */

    public function getNom(): string { return $this->nom; }
    public function getPv(): int { return $this->pv; }
    public function getPvMax(): int { return $this->pvMax; }
    public function getMana(): int { return $this->mana; }
    public function getManaMax(): int { return $this->manaMax; }
    public function getStrength(): int { return $this->strength; }
    public function getInitiative(): int { return $this->initiative; }
    public function getAttack(): int { return $this->attack; }
    public function getCapacity(): int { return $this->capacity; }
    public function getId(): int { return $this->id; }
    public function getDescription(): string { return $this->description; }

}
?>
