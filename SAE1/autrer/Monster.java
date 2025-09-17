package entity;

import java.util.List;

import fight.Spell;

public class Monster extends Entity{
	private String name;
		
	public Monster(int currentHP, int maximunHP, int armor, int attack, List<Spell> effects, String name) {
		super(currentHP, maximunHP, armor, attack, effects);
		this.name = name;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	
}
