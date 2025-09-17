package SAE2_1.model.worldio;

import SAE2_1.model.json.JSONObject;
import SAE2_1.model.json.JSONParser;
import SAE2_1.model.map.World;

import java.io.*;

public class WorldIO {

    public static void saveWorld(World w, File f) {
        if (w == null) {
            throw new IllegalArgumentException("Le monde à sauvegarder ne peut pas être null.");
        }

        try {
            if (!f.exists()) {
                boolean created = f.createNewFile();
                if (!created) {
                    System.err.println("Le fichier existe déjà : " + f.getAbsolutePath());
                } else {
                    System.out.println("Fichier créé : " + f.getAbsolutePath());
                }
            }

            try (FileWriter writer = new FileWriter(f)) {
                String jsonString = w.toJson();
                writer.write(jsonString);
                System.out.println("Monde sauvegardé avec succès dans : " + f.getAbsolutePath());
            }

        } catch (IOException e) {
            System.err.println("Erreur lors de la sauvegarde du monde : " + e.getMessage());
        }
    }

    public static World loadWorld(InputStream input) {
        if (input == null) {
            throw new IllegalArgumentException("Le flux d'entrée ne peut pas être null.");
        }

        StringBuilder json = new StringBuilder();
        try (BufferedReader reader = new BufferedReader(new InputStreamReader(input))) {
            String line;
            while ((line = reader.readLine()) != null) {
                json.append(line);
            }
        } catch (IOException e) {
            System.err.println("Erreur lors de la lecture du flux : " + e.getMessage());
            return null;
        }

        try {
            JSONParser parser = new JSONParser(json.toString());
            JSONObject jsonObject = parser.parse();
            World w = World.loadJson(jsonObject);
            System.out.println("Monde chargé : " + w.toString());
            return w;
        } catch (Exception e) {
            System.err.println("Erreur lors du parsing ou de la création du monde : " + e.getMessage());
            return null;
        }
    }
}
