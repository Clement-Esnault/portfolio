package SAE2_1.model.json;

import java.util.List;

public class JSONArray {
	
	public List<Object> data;
	
	public void add(Object objet) {
		data.add(objet);
	}
	
	public String getString(int index) throws ClassCastException{
		if(!data.get(index).equals(String.class)) {
			throw new ClassCastException();
		}
		return (String) data.get(index);
	}
	
	public Number getNumber(int index) throws ClassCastException{
		if(!data.get(index).equals(Number.class)) {
			throw new ClassCastException();
		}
		return (Number) data.get(index);
	}
	
	public Boolean getBoolean(int index) throws ClassCastException{
		if(!data.get(index).equals(Boolean.class)) {
			throw new ClassCastException();
		}
		return (Boolean) data.get(index);
	}
	
	public JSONObject getJSONObject(int index) throws ClassCastException{
		if(!data.get(index).equals(JSONObject.class)) {
			throw new ClassCastException();
		}
		return (JSONObject) data.get(index);
	}
	
	public JSONArray getJSONArray(int index) throws ClassCastException{
		if(!data.get(index).equals(JSONArray.class)) {
			throw new ClassCastException();
		}
		return (JSONArray) data.get(index);
	}
}
