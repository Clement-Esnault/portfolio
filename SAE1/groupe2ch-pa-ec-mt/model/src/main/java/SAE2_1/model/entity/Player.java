package SAE2_1.model.entity;

import java.util.List;
import SAE2_1.model.fight.Spell;

public class Player extends  Entity {
	
	private int currentMana;
	private int maximumMana ;
	private List<Spell> spells;
	
	public Player(int currentHP, int maximunHP, int armor, int attack, List<Spell> effects, int currentMana,
			int maximumMana, List<Spell> spells) {
		super(currentHP, maximunHP, armor, attack, effects);
		this.currentMana = currentMana;
		this.maximumMana = maximumMana;
		this.spells = spells;
	}
	
	public void castSpell(Spell spell, Entity target) {
		/*if((this.currentMana - spell.getCost()) >= 0) {
			for(Spell sp : spells) {
				if (sp==spell) {
					target.effects.add(spell);
				}
			}
		}*/
		
		 if (this.currentMana < spell.getCost()) {
		        System.out.println("Pas assez de mana pour lancer ce sort !");
		        return;
		    }
		
		 if (!spells.contains(spell)) {
		        System.out.println("Ce sort ne fait pas partie de la liste des sorts du joueur.");
		        return;
		    }
		this.currentMana -= spell.getCost();
		Spell clone = spell.clone();
		target.addEffect(clone);
	}
	
	public void regainMana(int mana) {
		this.currentMana= this.currentMana + mana;
	}
	
	
	// ---------------------- GETTERS AND SETTERS ----------------------
	
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
