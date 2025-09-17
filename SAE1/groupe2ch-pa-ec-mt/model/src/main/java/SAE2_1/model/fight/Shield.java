package SAE2_1.model.fight;

import SAE2_1.model.entity.Entity;

public class Shield extends Spell {
	
	private final int bonus;
    private boolean applied = false;
	private int originalArmor;
	
	public Shield() {
		super(5);
		this.bonus=5;
	}
	

	@Override
	public int getNbturnLeft() {
		return this.nbturnLeft;
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
		return this.nbturnLeft;
	}


	@Override
	public void specificEffect(Entity on) {
		if (!applied) {
			System.out.println("vous vous appliquez "+ 5 +" d'armures");
			originalArmor=on.getArmor();
			on.setArmor(originalArmor+bonus);
			applied=true;
		}
		if(nbturnLeft == 1) {
			System.out.println("Shield va expirer");
			on.setArmor(originalArmor);
			applied=false;
		}
		
	}


	@Override
	public boolean isSelfSpell() {
		
		return true;
	}


	@Override
	public String toString() {
		
		return "Shield";
	}


	@Override
	public Spell clone() {
		
		return new Shield();
	}

	
	
}
