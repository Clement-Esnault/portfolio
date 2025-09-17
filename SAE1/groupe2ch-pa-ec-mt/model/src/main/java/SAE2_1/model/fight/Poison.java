package SAE2_1.model.fight;

import SAE2_1.model.entity.Entity;

public class Poison extends Spell {
	
	private boolean applied = false;
	public Poison() {
		super(5);
	}

	@Override
	public int getNbturnLeft() {
		return this.nbturnLeft;
	}

	@Override
	public int getAmount() {
		return 10;
	}

	@Override
	public int getCost() {
		return 15;
	}

	@Override
	public int getDuration() {
		return 5;
	}

	@Override
	public void specificEffect(Entity on) {
		
		System.out.println(on.getClass().getSimpleName() +"  prend "+3+" de dégats");
		on.takeDamage(this.getAmount());
		
	}

	@Override
	public boolean isSelfSpell() {
		return false;
	}

	@Override
	public String toString() {
		return "Poison";
	}
	
	@Override
	public Spell clone() {
	    return new Poison();
	}

}
