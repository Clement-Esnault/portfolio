package SAE2_1.model.fight;

import SAE2_1.model.entity.Entity;
import SAE2_1.model.entity.Player;

public class ManaGain extends Spell{

	public ManaGain() {
		super(1);
	}

	
	
	@Override
	public int getNbturnLeft() {
		return this.nbturnLeft;
	}

	@Override
	public int getAmount() {
		return 20;
	}

	@Override
	public int getCost() {
		return 10;
	}

	@Override
	public int getDuration() {
		return 1;
	}



	@Override
	public void specificEffect(Entity on) {
		if(on instanceof Player player) {
			if (player.getCurrentMana()+20 < player.getMaximumMana()) {
				player.setCurrentMana(player.getCurrentMana()+20);
				System.out.println("vous avez restauré votre mana de"+20+"points");
			}
			else {
				player.setCurrentMana(player.getMaximumMana());
				System.out.println("regain de mana a expiré");
			}
		}
		
	}



	@Override
	public boolean isSelfSpell() {
		
		return true;
	}



	@Override
	public String toString() {
	
		return "Mana gain";
	}



	@Override
	public Spell clone() {
		
		return new ManaGain();
	}
	

}
