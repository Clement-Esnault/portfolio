package SAE2_1.model.map;

import java.util.HashMap;
import java.util.List;

import SAE2_1.model.entity.Monster;

public class Place {
	
	private int id;
	private String name;
	private Monster monster;
	private String description;
	private boolean isEnd;
	private boolean isStart;
	private boolean isDefeat;
	private HashMap<Path, Place> paths = new HashMap<>();
	
	public Place(int id, String name, Monster monster, String description, boolean isEnd, boolean isStart,
			boolean isDefeat) {
		super();
		this.id = id;
		this.name = name;
		this.monster = monster;
		this.description = description;
		this.isEnd = isEnd;
		this.isStart = isStart;
		this.isDefeat = isDefeat;
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public Monster getMonster() {
		return monster;
	}

	public void setMonster(Monster monster) {
		this.monster = monster;
	}

	public String getDescription() {
		return description;
	}

	public void setDescription(String description) {
		this.description = description;
	}

	public boolean isEnd() {
		return isEnd;
	}

	public void setEnd(boolean isEnd) {
		this.isEnd = isEnd;
	}

	public boolean isStart() {
		return isStart;
	}

	public void setStart(boolean isStart) {
		this.isStart = isStart;
	}

	public boolean isDefeat() {
		return isDefeat;
	}

	public void setDefeat(boolean isDefeat) {
		this.isDefeat = isDefeat;
	}
	
	public void addPath(Path path) {
        Place other = path.ObtenirAutre(this);
        paths.put(path, other);
    }

	@SuppressWarnings("null")
	public List<Place> getAdjacentsPlace(){
		List<Place> liste = null;
		liste.add((Place) paths.keySet());
		return liste; 
		
	}
	
	public HashMap<Path, Place> getPaths(){
		return paths;
	}
}
