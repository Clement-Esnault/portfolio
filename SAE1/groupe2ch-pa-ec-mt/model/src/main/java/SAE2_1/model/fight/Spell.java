package SAE2_1.model.fight;

import java.util.ArrayList;
import java.util.List;

import SAE2_1.model.entity.Entity;

public abstract class Spell  {

	protected final int duration;
	protected int nbturnLeft;
	protected int amount;
	protected int cost;

	public Spell(int duration) {

		this.duration = duration;
		this.nbturnLeft = duration;
	}

	public static boolean apply(Entity on) {
		if(on==null) {
			return false;
		}
		List<Spell> toRemove = new ArrayList<>();
		List<Spell> activeSpells = new ArrayList<>(on.getEffects());
		
	    for (Spell spell : activeSpells) {
	        spell.specificEffect(on); 
	        spell.nbturnLeft--;
	        if (spell.getNbturnLeft()<=0) {
	            toRemove.add(spell);
	        }
	    }

	    on.getEffects().removeAll(toRemove);
	    return true;
		}

	public abstract void specificEffect(Entity on);

	public abstract boolean isSelfSpell();

	public boolean isFinished() {
		return this.nbturnLeft <= 0;
	}

	 public abstract Spell clone();

	public abstract int getNbturnLeft();

	public abstract int getAmount();

	public abstract int getCost();

	public abstract int getDuration();
	
	public abstract String toString();
}
