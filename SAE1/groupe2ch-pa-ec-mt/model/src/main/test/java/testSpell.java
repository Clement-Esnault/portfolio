import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Scanner;

import SAE2_1.model.entity.Monster;
import SAE2_1.model.entity.Player;
import SAE2_1.model.fight.Heal;
import SAE2_1.model.fight.ManaGain;
import SAE2_1.model.fight.Poison;
import SAE2_1.model.fight.Shield;
import SAE2_1.model.fight.Spell;
import SAE2_1.model.fight.Strenght;
import SAE2_1.model.map.World;

public class testSpell {
	
	public void main() {
		World world = new World("Nouveau monde", new HashMap());
		List<Spell> effects = new ArrayList<>();
		List<Spell> spells = new ArrayList<>();
		Scanner scanner = new Scanner(System.in);
		spells.add(new Heal(5));
		spells.add(new Poison());
		spells.add(new Shield());
		spells.add(new Strenght());
		spells.add(new ManaGain());
		Monster monster = new Monster(100,100,1,1,effects,"abab");
		Player player = new Player(100,100,10,45,effects, 100, 100, spells);
		
		//tests
		Poison.apply(monster);
		if(Poison instanceof monster.getEffects()) {
			System.out.println("c'est bon pour la Apply");
		}
		
		
}