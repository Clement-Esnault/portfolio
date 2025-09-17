package entity;

import java.util.List;

import fight.Spell;

public class Entity {
	
	protected int currentHP;
	protected int maximunHP;
	protected int armor;
	protected int attack;
	protected List<Spell> effects;
	
	public Entity(int currentHP, int maximunHP, int armor, int attack, List<Spell> effects) {
		this.currentHP = currentHP;
		this.maximunHP = maximunHP;
		this.armor = armor;
		this.attack = attack;
		this.effects = effects;
	}
	
	public boolean isAlive() {
		return true;
	}
	
	public boolean isDead() {
		return true;
	}

	public int getCurrentHP() {
		return currentHP;
	}

	public void setCurrentHP(int currentHP) {
		this.currentHP = currentHP;
	}

	public int getMaximunHP() {
		return maximunHP;
	}

	public void setMaximunHP(int maximunHP) {
		this.maximunHP = maximunHP;
	}

	public int getArmor() {
		return armor;
	}

	public void setArmor(int armor) {
		this.armor = armor;
	}

	public int getAttack() {
		return attack;
	}

	public void setAttack(int attack) {
		this.attack = attack;
	}

	public List<Spell> getEffects() {
		return effects;
	}

	public void setEffects(List<Spell> effects) {
		this.effects = effects;
	}
	
	
}
