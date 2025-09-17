package SAE2_1.model.entity;

import java.util.ArrayList;
import java.util.List;

import SAE2_1.model.fight.Spell;
import SAE2_1.model.json.JSONObject;


public class Monster extends Entity{
	private String name;
		
	public Monster(int currentHP, int maximunHP, int armor, int attack, List<Spell> effects, String name) {
		super(currentHP, maximunHP, armor, attack, effects);
		this.name = name;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}
	
	public Monster createMonsterFromJSON(JSONObject json) {
		int currentHP = (int) json.getNumber("currentHP");

        int maximunHP = (int) json.getNumber("maximunHP");
        int armor = (int) json.getNumber("armor");
        int attack = (int) json.getNumber("attack");
        String name = json.getString("name");
        List<Spell> effects = new ArrayList<>();
		return new Monster(currentHP,maximunHP,armor,attack,effects,name);
	}

	

		


}
