package entity;

import java.util.List;

import fight.Spell;

public class Player extends  Entity {
	
	private int currentMana;
	private int maximumMana ;
	private  List<Spell> spells;
	
	public Player(int currentHP, int maximunHP, int armor, int attack, List<Spell> effects, int currentMana,
			int maximumMana, List<Spell> spells) {
		super(currentHP, maximunHP, armor, attack, effects);
		this.currentMana = currentMana;
		this.maximumMana = maximumMana;
		this.spells = spells;
	}
	
	public void castSpell(Spell spell, Entity target) {
		
	}

	public int getCurrentMana() {
		return currentMana;
	}

	public void setCurrentMana(int currentMana) {
		this.currentMana = currentMana;
	}

	public int getMaximumMana() {
		return maximumMana;
	}

	public void setMaximumMana(int maximumMana) {
		this.maximumMana = maximumMana;
	}

	public List<Spell> getSpells() {
		return spells;
	}

	public void setSpells(List<Spell> spells) {
		this.spells = spells;
	}
}
