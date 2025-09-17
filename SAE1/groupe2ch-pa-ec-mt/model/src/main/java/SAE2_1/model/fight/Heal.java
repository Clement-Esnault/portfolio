package SAE2_1.model.fight;

import SAE2_1.model.entity.Entity;
import SAE2_1.model.entity.Player;

public class Heal extends Spell {

	public Heal(int duration) {
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
		return 20;
	}

	@Override
	public int getDuration() {
		return 1;
	}

	@Override
	public void specificEffect(Entity on) {
		if(on instanceof Player player) {
			if (player.getCurrentHP()+20 < player.getMaximunHP()) {
				player.Healing(this.getAmount());
				System.out.println("vous avez été soigné de"+20+"hp");
			}
			else {
				player.setCurrentHP(player.getMaximunHP());
				System.out.println("Le sort de soin a expiré");
			}
		}
	}

	@Override
	public boolean isSelfSpell() {
		
		return true;
	}

	@Override
	public String toString() {
		
		return "Heal";
	}

	@Override
	public Spell clone() {
		
		return new Heal(duration);
	}
	
	

}
