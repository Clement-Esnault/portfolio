package SAE2_1.model.fight;

import SAE2_1.model.entity.Entity;

public class Strenght extends Spell {

	private final int bonus;
	private boolean applied = false;
	private int originalAttack;

	public Strenght() {
		super(3);
		this.bonus = 5;
	}

	@Override
	public int getNbturnLeft() {
		return 3;
	}

	@Override
	public int getAmount() {
		return 1;
	}

	@Override
	public int getCost() {
		return 10;
	}

	@Override
	public int getDuration() {
		return 3;
	}

	@Override
	public void specificEffect(Entity on) {
		if (!applied) {
			System.out.println("vous vous appliquez " + 5 + " d'attaques");
			originalAttack = on.getAttack();
			on.setAttack(originalAttack + bonus);
			applied = true;
		}
		if (nbturnLeft == 1) {
			System.out.println("Strenght va expirer");
			on.setAttack(originalAttack);
			applied = false;
		}
		
		/*@Override
	public void specificEffect(Entity on) {
		if (!applied) {
			System.out.println("vous vous appliquez "+ 5 +" d'armures");
			originalArmor=on.getArmor();
			on.setArmor(originalArmor+bonus);
			applied=true;
		}
		if(nbturnLeft == 0) {
			System.out.println("Shield va expirer");
			on.setArmor(originalArmor);
			applied=false;
		}*/

	}

	@Override
	public boolean isSelfSpell() {

		return true;
	}

	@Override
	public String toString() {

		return "Strenght";
	}

	@Override
	public Spell clone() {
		// TODO Auto-generated method stub
		return new Strenght();
	}

}
