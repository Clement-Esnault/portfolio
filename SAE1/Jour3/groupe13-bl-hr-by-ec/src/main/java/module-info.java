module sae2025 {
    requires javafx.graphics;
    requires javafx.fxml;
    requires javafx.controls;
    requires java.net.http;
    requires java.desktop;
	requires javafx.base;

    opens app.model.map;

    opens app to javafx.fxml;
    exports app;
    opens app.fxml to javafx.fxml;
    exports app.fxml;
    opens app.fxml.controleurs to javafx.fxml;
    exports app.fxml.controleurs;
    opens app.graphicplace to javafx.fxml;
    exports app.graphicplace;
    
    
}