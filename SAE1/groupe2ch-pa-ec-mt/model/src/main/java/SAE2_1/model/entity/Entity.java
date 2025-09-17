package SAE2_1.model.entity;

import java.util.List;



import SAE2_1.model.fight.*;
public abstract class Entity {
	
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
		return this.currentHP>0;
	}
	
	public boolean isDead() {
		return this.currentHP<=0;
	}

	public void attack(Entity other) {
		other.currentHP =other.currentHP - this.attack;
	}
	
	public void addEffect(Spell spell) {
		 for (Spell s : effects) {
		        if (s.getClass().equals(spell.getClass())) {
		            return;
		        }
		    }
		    this.effects.add(spell);
	}
	
	public void takeDamage(int d) {
		if(d- this.armor > 1) {
			this.currentHP=this.currentHP-(d-this.armor);
		}
		else { this.currentHP -= 1;}
	}
	public void Healing(int h) {
		this.currentHP=this.currentHP+h;
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
