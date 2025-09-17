package SAE2_1.model.controller;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Scanner;

import SAE2_1.model.entity.Monster;
import SAE2_1.model.entity.Player;
import SAE2_1.model.fight.Fight;
import SAE2_1.model.fight.Heal;
import SAE2_1.model.fight.ManaGain;
import SAE2_1.model.fight.Poison;
import SAE2_1.model.fight.Shield;
import SAE2_1.model.fight.Spell;
import SAE2_1.model.fight.Strenght;
import SAE2_1.model.map.Path;
import SAE2_1.model.map.Place;
import SAE2_1.model.map.World;

public class Game {

	public static void main(String[] args) {
		play();
	}
	
	
	public static void play() {
		World world = new World("Nouveau monde", new HashMap());
		List<Spell> effects = new ArrayList<>();
		List<Spell> spells = new ArrayList<>();
		Scanner scanner = new Scanner(System.in);
		spells.add(new Heal(5));
		spells.add(new Poison());
		spells.add(new Shield());
		spells.add(new Strenght());
		spells.add(new ManaGain());
		//Monster monster = null;
		Monster monster = new Monster(100,100,1,1,effects,"abab");
		Player player = new Player(100,100,10,45,effects, 100, 100, spells);
		Fight fight = new Fight(player,monster);
		
		// Pour Antoine: le monster par défaut est Null, mais il faut lui mettre les parametre du monstre de la zone
		// Donc Null ou un monstre, le system de combat est juste en dessous et il est automatique, faudra
		// Juste faire les choix des zones à parcourir
		// Pour la boucle c'ets tant que le Joueur n'a pas atteint la Tour du Salut
		// Il faut aussi donner l'option au joueur d'arreter le programme à un moment lorsqu'il tape 1
		// Il y a une dupplication des sorts
		
			while(fight.getWinner()==null && fight.estPresent(monster)==true) {
				System.out.println("Spells connue :");
		        for (int i = 0; i < player.getSpells().size(); i++) {
		            System.out.println(" " + i + " - " + player.getSpells().get(i).toString() + "(" + player.getSpells().get(i).getCost() + ")");
		        }
		        System.out.print("Choisissez un sort (index) ou -1 pour attaque de base : ");
		        int choice = scanner.nextInt();
		        Spell selectedSpell = null;
		        
		        if (choice >= 0 && choice < player.getSpells().size()) {        	
		            selectedSpell = player.getSpells().get(choice);
		            System.out.println("Vous lancez: " +  player.getSpells().get(choice).toString());
		        }
		        else {
		        	selectedSpell=null;
		        	System.out.println("vous lancez Attaque basique");
		        }
				fight.turn(selectedSpell);
				//System.out.println("\nVictoire de : " + fight.getWinner().getClass().getSimpleName());
			}
		
	}

	
	
	
	
	
	
	
	
	
	
	/*
	 * 
	 * System de COMBAT PAS AUTO
	 * World world = new World("Nouveau monde", new HashMap());
		List<Spell> effects = new ArrayList<>();
		List<Spell> spells = new ArrayList<>();
		  Scanner scanner = new Scanner(System.in);
		spells.add(new Heal(5));
		spells.add(new Poison());
		Monster monster = new Monster(100,100,1,1,effects,"ababa");
		Player player = new Player(100,100,1,45,effects, 100, 100, spells);
		Fight fight = new Fight(player,monster);
		while(fight.getWinner()==null) {
			System.out.println("Spells connue :");
	        for (int i = 0; i < player.getSpells().size(); i++) {
	            System.out.println(" " + i + " - " + player.getSpells().get(i).toString());
	        }
	        System.out.print("Choisissez un sort (index) ou -1 pour attaque de base : ");
	        int choice = scanner.nextInt();
	        Spell selectedSpell = null;
	        
	        if (choice >= 0 && choice < player.getSpells().size()) {        	
	            selectedSpell = player.getSpells().get(choice);
	            System.out.println("Vous lancez: " +  player.getSpells().get(choice).toString());
	        }
	        else {
	        	selectedSpell=null;
	        	System.out.println("vous lancez Attaque basique");
	        }
			fight.turn(selectedSpell);
		}
		 System.out.println("\nVictoire de : " + fight.getWinner().getClass().getSimpleName());
	}*/
	
	
}
