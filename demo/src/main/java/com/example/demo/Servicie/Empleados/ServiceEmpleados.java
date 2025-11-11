package com.example.demo.Servicie.Empleados;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.Base64;
import java.util.List;

@Service
public class ServiceEmpleados {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    // ---------------------- OBTENER ----------------------
    public List<String> obtenerEmpleados() {
        String sql = "SELECT Documento_Empleado,Tipo_Documento, Nombre_Usuario, Apellido_Usuario,Edad, Correo_Electronico,Telefono,Genero,ID_Estado,ID_Rol,Fotos FROM Empleados";
        return jdbcTemplate.query(sql, (rs, rowNum) ->
                rs.getString("Documento_Empleado") +
                        "________" + rs.getString("Tipo_Documento") +
                        "________" + rs.getString("Nombre_Usuario") +
                        "________" + rs.getString("Apellido_Usuario") +
                        "________" + rs.getString("Edad") +
                        "________" + rs.getString("Correo_Electronico") +
                        "________" + rs.getString("Telefono") +
                        "________" + rs.getString("Genero") +
                        "________" + rs.getString("ID_Estado") +
                        "________" + rs.getString("ID_Rol") +
                        "________" + rs.getString("Fotos")
        );
    }

    // ---------------------- INSERTAR ----------------------
    public void agregarEmpleado(String Documento_Empleado, String Tipo_Documento, String Nombre_Usuario,
                                String Apellido_Usuario, String Edad, String Correo_Electronico,
                                String Telefono, String Genero, String ID_Estado, String ID_Rol, String Fotos) {

        Fotos = guardarBase64SiViene(Fotos, Documento_Empleado);

        String sql = "INSERT INTO Empleados (Documento_Empleado, Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad, Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, Fotos) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        jdbcTemplate.update(sql, Documento_Empleado, Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, Fotos);
    }

    // ---------------------- ACTUALIZAR ----------------------
    public int actualizarEmpleado(String Documento_Empleado, String Tipo_Documento, String Nombre_Usuario,
                                  String Apellido_Usuario, String Edad, String Correo_Electronico,
                                  String Telefono, String Genero, String ID_Estado, String ID_Rol, String Fotos) {

        Fotos = guardarBase64SiViene(Fotos, Documento_Empleado);

        String sql = "UPDATE Empleados SET Tipo_Documento=?, Nombre_Usuario=?, Apellido_Usuario=?, Edad=?, " +
                "Correo_Electronico=?, Telefono=?, Genero=?, ID_Estado=?, ID_Rol=?, Fotos=? WHERE Documento_Empleado=?";

        return jdbcTemplate.update(sql, Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, Fotos, Documento_Empleado);
    }

    // ---------------------- ELIMINAR ----------------------
    public int eliminarEmpleado(String Documento_Empleado) {
        String sql = "DELETE FROM Empleados WHERE Documento_Empleado=?";
        return jdbcTemplate.update(sql, Documento_Empleado);
    }

    // ---------------------- GUARDAR FOTO ----------------------
    private String guardarBase64SiViene(String base64, String documento) {
        try {
            if (base64 == null || base64.isBlank()) return base64;

            // Si viene con prefijo tipo "data:image/jpeg;base64,", quitarlo
            int coma = base64.indexOf(',');
            if (coma != -1) base64 = base64.substring(coma + 1);

            byte[] bytes = Base64.getDecoder().decode(base64);

            Path uploads = Paths.get("uploads");
            if (!Files.exists(uploads)) {
                Files.createDirectories(uploads);
            }

            String safeDoc = documento.replaceAll("[^A-Za-z0-9_-]", "_");
            Path destino = uploads.resolve("empleado_" + safeDoc + "_" + System.currentTimeMillis() + ".jpg");

            Files.write(destino, bytes);

            // Guardar la ruta relativa
            return destino.toString();
        } catch (Exception e) {
            e.printStackTrace();
            return "";
        }
    }
}
