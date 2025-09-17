package SAE2_1.model.fight;

import SAE2_1.model.entity.Entity;
import SAE2_1.model.entity.Monster;
import SAE2_1.model.entity.Player;

public class Fight {

	private final Player player;
	private final Monster monster;

	public Fight(Player player, Monster monster) {
		super();
		this.player = player;
		this.monster = monster;
	}
	
	public boolean estPresent(Monster monster) {
		if(this.monster==null) {
			return false;
		}
		return true;
	}
	
	public Entity getWinner() {
		if (monster == null) {
			System.out.println("il n'y a rien a combattre");
			return null;
		}
		if (player.isDead()) {
			System.out.println("Le Joueur est KO");
			return monster;
		}
		if (monster.isDead()) {
			System.out.println("Le Monstre est KO");
			return player;
		}
		return null;
	}

	public Entity turn(Spell spell) {
		System.out.println("Player :");
		System.out.println("HP: "+player.getCurrentHP()+"/"+player.getMaximunHP()+" ARM: "+player.getArmor()+" ATT: "+player.getAttack()+" MANA: "+player.getCurrentMana());
		System.out.println("Monster :");
		System.out.println("HP: "+monster.getCurrentHP()+"/"+monster.getMaximunHP()+" ARM: "+monster.getArmor()+" ATT: "+monster.getAttack());
		if(this.monster==null) {
			return getWinner();
		}
		if (spell != null && this.monster != null && spell.getCost() <= player.getCurrentMana()) {
			Spell clonedSpell = spell.clone();
			System.out.println("Le joueur lance un sort !");
			player.setCurrentMana(player.getCurrentMana() - clonedSpell.getCost());

			if (clonedSpell instanceof Poison) {
			    monster.addEffect(clonedSpell);
			    System.out.println("Vous avez lancé un sort de poison au monstre.");
			}
			else if (clonedSpell.isSelfSpell()==true) {
			    player.addEffect(clonedSpell);
			    System.out.println("Vous vous êtes lancé un sort.");
			}
			else {
			    monster.addEffect(clonedSpell);
			    System.out.println("Vous avez lancé un sort au monstre.");
			}
		}
		else {
			int damage = Math.max(player.getAttack() - monster.getArmor(), 1);
			System.out.println("Le joueur attaque et inflige "+damage+" de dégats");
			monster.takeDamage(damage);
			System.out.println("le monstre a "+monster.getCurrentHP() + " de vie restant");
		}
		if (monster.isAlive()) {
			int damage = Math.max(monster.getAttack() - player.getArmor(), 1);
			System.out.println("Le monstre attaque et inflige "+damage+" de dégats");
			player.takeDamage(damage);
			System.out.println("le joueure a "+player.getCurrentHP() + " de vie restant");
		}

		return newTurn();
	}

	public Entity newTurn() {
		Spell.apply(player);
		if(player.getEffects().isEmpty()) {
			System.out.println("le joueur ne subit pas d'effets de Spells");
		}
		else {
			System.out.println("le joueur subit des effets de Spells");
			for (int i = 0; i < player.getEffects().size(); i++) {
	            System.out.println("   " + player.getEffects().get(i).toString() + "(" + player.getEffects().get(i).getNbturnLeft() + ")");
	        }
		}
		Spell.apply(monster);
		if(monster.getEffects().isEmpty()) {
			System.out.println("le monster ne subit pas d'effets de Spells");
		}
		else {
			System.out.println("le monster subit des effets de Spells");
			for (int i = 0; i < monster.getEffects().size(); i++) {
	            System.out.println("  " + monster.getEffects().get(i).toString() + "(" + monster.getEffects().get(i).getNbturnLeft() + ")");
	        }
		}
		return getWinner();
	}

}
