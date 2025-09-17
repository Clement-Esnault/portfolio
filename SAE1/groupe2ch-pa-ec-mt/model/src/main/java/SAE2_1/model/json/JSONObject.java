package SAE2_1.model.json;

import java.util.HashMap;

public class JSONObject {
	
	public HashMap<String, Object> data;
	
	public void put(String key, Object objet) {
		data.put(key, objet);
	}
	
	public String getString(String key) throws ClassCastException {
		if(!data.get(key).equals(String.class)) {
			throw new ClassCastException();
		}
		return (String) data.get(key);
	}
	
	public Number getNumber(String key) throws ClassCastException{
		if(!data.get(key).equals(Number.class)) {
			throw new ClassCastException();
		}
		return (Number) data.get(key);
	}
	
	public Boolean getBoolean(String key) throws ClassCastException{
		if(!data.get(key).equals(Boolean.class)) {
			throw new ClassCastException();
		}
		return (Boolean) data.get(key);
	}
	
	public JSONObject getJSONObject(String key) throws ClassCastException{
		if(!data.get(key).equals(JSONObject.class)) {
			throw new ClassCastException();
		}
		return (JSONObject) data.get(key);
	}
	
	public JSONArray getJSONArray(String key) throws ClassCastException{
		if(!data.get(key).equals(JSONArray.class)) {
			throw new ClassCastException();
		}
		return (JSONArray) data.get(key);
	}

	public JSONObject get(String string) {
		// TODO Auto-generated method stub
		return null;
	}
}
