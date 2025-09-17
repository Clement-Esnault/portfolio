package SAE2_1.model.map;

import java.util.HashMap;

import SAE2_1.model.entity.Monster;
import SAE2_1.model.json.JSONArray;
import SAE2_1.model.json.JSONObject;

public class World {

	private String name;
	public HashMap<Place, HashMap<Path, Place>> cache;
	
	public World(String name, HashMap<Place, HashMap<Path, Place>> cache) {
		super();
		this.name = name;
		this.cache = cache;
	}

	public String getName() {
		return name;
	}
	
	public void setName(String name) {
		this.name = name;
	}

	public HashMap<Place, HashMap<Path, Place>> getCache() {
		return cache;
	}

	public void setCache(HashMap<Place, HashMap<Path, Place>> cache) {
		this.cache = cache;
	}

	public void addPlace(Place place) {
		cache.putIfAbsent(place, new HashMap<>());
	}

	public void addPath(Path path) throws UnknownPlaceException {
		if (!cache.containsKey(path.getFirstPlace()) || !cache.containsKey(path.getSecondPlace())) {
			throw new UnknownPlaceException("Place inconnue dans le path");
		}
		cache.get(path.getFirstPlace()).put(path, path.getSecondPlace());
		cache.get(path.getSecondPlace()).put(path, path.getFirstPlace());
	}

	public Place getPlaceFromName(String name) {
		return cache.keySet().stream().filter(nomATester -> nomATester.getName().equals(name)).findFirst().orElse(null);
	}

	public Place getPlaceFromId(int id) {
		return cache.keySet().stream().filter(idATester -> idATester.getId() == id).findFirst().orElse(null);
	}

	public HashMap<Path, Place> getPathsFrom(Place place) {
		return cache.getOrDefault(place, new HashMap<>());

	}

	public static World loadJson(JSONObject jsonObject) {
		// TODO Auto-generated method stub
		return null;
	}

	public String toJson() {
		// TODO Auto-generated method stub
		return null;
	}

}
