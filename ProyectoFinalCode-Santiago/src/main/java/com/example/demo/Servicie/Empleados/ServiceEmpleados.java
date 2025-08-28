package com.example.demo.Servicie.Empleados;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class ServiceEmpleados {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    public List<String> obtenerEmpleados() {
        String sql = "SELECT Documento_Empleado, Nombre_Usuario, Apellido_Usuario, Correo_Electronico FROM Empleados";
        return jdbcTemplate.query(sql, (rs, rowNum) ->
                rs.getString("Documento_Empleado") + " | " +
                        rs.getString("Nombre_Usuario") + " " + rs.getString("Apellido_Usuario") + " | " +
                        rs.getString("Correo_Electronico")
        );
    }

    public void agregarEmpleado(String Documento_Empleado, String Tipo_Documento, String Nombre_Usuario,
                                String Apellido_Usuario, String Edad, String Correo_Electronico,
                                String Telefono, String Genero, String ID_Estado, String ID_Rol, String Fotos) {
        String sql = "INSERT INTO Empleados (Documento_Empleado, Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad, Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, Fotos) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        jdbcTemplate.update(sql, Documento_Empleado, Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, Fotos);
    }

    public int actualizarEmpleado(String Documento_Empleado, String Nombre_Usuario, String Apellido_Usuario,
                                  String Edad, String Telefono, String ID_Estado, String ID_Rol, String Fotos) {
        String sql = "UPDATE Empleados SET Nombre_Usuario=?, Apellido_Usuario=?, Edad=?, Telefono=?, ID_Estado=?, ID_Rol=?, Fotos=? WHERE Documento_Empleado=?";
        return jdbcTemplate.update(sql, Nombre_Usuario, Apellido_Usuario, Edad, Telefono, ID_Estado, ID_Rol, Fotos, Documento_Empleado);
    }

    public int eliminarEmpleado(String Documento_Empleado) {
        String sql = "DELETE FROM Empleados WHERE Documento_Empleado=?";
        return jdbcTemplate.update(sql, Documento_Empleado);
    }
}