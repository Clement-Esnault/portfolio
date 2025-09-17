package SAE2_1.model.map;

import java.util.HashMap;

public class Path extends World {
	
	public Place firstPlace;
	public Place secondPlace;
	public int length;
	
	public Path(String name, HashMap<Place, HashMap<Path, Place>> cache, Place firstPlace, Place secondPlace,
			int length) {
		super(name, cache);
		this.firstPlace = firstPlace;
		this.secondPlace = secondPlace;
		this.length = length;
	}
	
	public Place getFirstPlace() {
		return firstPlace;
	}
	
	public void setFirstPlace(Place firstPlace) {
		this.firstPlace = firstPlace;
	}
	
	public Place getSecondPlace() {
		return secondPlace;
	}
	
	public void setSecondPlace(Place secondPlace) {
		this.secondPlace = secondPlace;
	}
	
	public int getLength() {
		return length;
	}
	
	public void setLength(int length) {
		this.length = length;
	}

	public Place ObtenirAutre(Place place) {
		if (place.equals(firstPlace)) {
		    return secondPlace;
		} else {
		    return firstPlace;
		}
	}

	public Object getDistance() {
		// TODO Auto-generated method stub
		return null;
	}
}
