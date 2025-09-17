package SAE2_1.model.json;

public class JSONParser {
	
	private String toParse;
	private int compteur;

	public JSONParser(String toParse) {
		this.toParse = toParse.replaceAll("\\s+(?=(?:[ˆ\"]*\"[ˆ\"]*\")*[ˆ\"]*)", "");
	} 
	
	public JSONObject parse() {
		return parseObject();		
	}
	
	public Object parseValue() {
		switch(toParse.charAt(this.compteur)) {
		case '"':
			return parseString();
		case '{':
			return parseObject();
		case 't' :
			return parseBoolean();
		case 'f':
			return parseBoolean();
		case '0', '1', '2', '3', '4', '5', '6', '7', '8', '9':
			return parseNumber();
		}
		return parseNull();
	}
	
	public String parseString() {
		String chaine = "";
		while (toParse.charAt(this.compteur) != '"') {
			chaine += toParse.charAt(this.compteur);
			this.compteur += 1;
		}
		this.compteur += 1; 
		return chaine;
	}
	
	public Boolean parseBoolean() {
		String chaine = "";
		while (toParse.charAt(this.compteur) != ',' && toParse.charAt(this.compteur) != '}') {
			chaine += toParse.charAt(this.compteur);
			this.compteur += 1;
		}
		this.compteur += 1; 
		return Boolean.valueOf(chaine);
	}
	
	public Number parseNumber() {
		String chaine = "";
		while (toParse.charAt(this.compteur) != ',' && toParse.charAt(this.compteur) != '}') {
			chaine += toParse.charAt(this.compteur);
			this.compteur += 1;
		}
		this.compteur += 1; 
		if(chaine.contains(".")){
			return Double.valueOf(chaine);
		}else {
			return Integer.valueOf(chaine);
		}
	}
	
	public Object parseNull() {
		return null;
	}
	
	public JSONArray parseArray() {
		JSONArray jsonArray = new JSONArray();
		this.compteur += 1;
		char charactere = toParse.charAt(this.compteur);
		while (charactere != '}') {
			Object value = parseValue();
			jsonArray.add(value);
			if(charactere == ',') {
				this.compteur += 1;
			}
		}
		this.compteur += 1;
		return jsonArray;
	}
	
	public JSONObject parseObject() {
		JSONObject jsonObject = new JSONObject();
		this.compteur += 1;
		char charactere = toParse.charAt(this.compteur);
		while (charactere != '}') {
			if(charactere == ',') {
				this.compteur += 1;
			}else {
				this.compteur -= 1;
				String key = parseString();
				this.compteur += 1;
				Object value = parseValue();
				jsonObject.put(key, value);
			}
		}
		this.compteur += 1;
		return jsonObject;
	}
}