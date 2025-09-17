package app.graphicplace;

import java.io.IOException;
import java.util.Random;

import app.Main;
import app.fxml.controleurs.MainController;
import app.model.map.Place;
import app.model.map.World;
import app.model.parser.WorldIO;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.control.Label;
import javafx.scene.layout.Pane;
import javafx.scene.shape.Circle;

public class GraphicPlace extends Circle {
	
	public MainController app;
	private Place place;
	private Label nom;
	@FXML private Pane zoneGraphique;
	private World world;
    @FXML private Circle circle;
    @FXML private Label label;

	
	/*public GraphicPlace(MainController app) {
        this.app = app;
    }*/
	
	public GraphicPlace() {
		
	}
	
	/*public void AddGraphicPlace(Place place, Pane zoneGraphique) {
		this.ajouterCercle(zoneGraphique);
	}*/
	
	public void setApp(MainController app) {
		this.app=app;
		zoneGraphique.widthProperty().addListener((obs, oldVal, newVal) -> {
	        if (newVal.doubleValue() > 0 && zoneGraphique.getHeight() > 0) {
	        	ajouterTouteslesPlaces();
	        }
	    });
	
		zoneGraphique.heightProperty().addListener((obs, oldVal, newVal) -> {
	        if (newVal.doubleValue() > 0) {
	        	ajouterTouteslesPlaces();
	        }
	    });
		
		//ajouterTouteslesPlaces();
		
		
	}
	
	
	public void ajouterTouteslesPlaces() {
		zoneGraphique.getChildren().clear(); // pour éviter d’empiler les cercles à chaque resize
	    for (Place place : app.world.getPlaces()) {
	    	ajouterCercle(place);
	    }
	}
	
	public void ajouterCercle(Place Place) {
		System.out.println(Place.getName());
		Random rand = new Random();
	    double radius = 15 + rand.nextDouble() * 30; 
	    double width = zoneGraphique.getWidth();
        double height = zoneGraphique.getHeight();
	    double x = rand.nextDouble() * (width - 2 * radius);
	    double y = rand.nextDouble() * (height - 2 * radius);

	    Circle cercle = new Circle(x + radius, y + radius, radius);
	   

	    zoneGraphique.getChildren().add(cercle);
	}
	
	public Place getPlace() {
		return place;
	}
	public Label getLabel() {
		return label;
	}
}
