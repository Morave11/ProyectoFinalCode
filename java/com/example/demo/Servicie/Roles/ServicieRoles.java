package com.example.demo.Servicie.Roles;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class ServicieRoles {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    // Listar roles
    public List<String> obtenerRoles() {
        String sql = "SELECT ID_Rol, Nombre FROM roles";
        return jdbcTemplate.query(sql, (rs, rowNum) ->
                rs.getString("ID_Rol") + " - " + rs.getString("Nombre")
        );
    }

    // Agregar un rol
    public void agregarRol(String ID_Rol, String Nombre) {
        String sql = "INSERT INTO roles (ID_Rol, Nombre) VALUES (?, ?)";
        jdbcTemplate.update(sql, ID_Rol, Nombre);
    }

    // Actualizar un rol
    public int actualizarRol(String ID_Rol, String Nombre) {
        String sql = "UPDATE roles SET Nombre = ? WHERE ID_Rol = ?";
        return jdbcTemplate.update(sql, Nombre, ID_Rol);
    }

    // Eliminar un rol
    public int eliminarRol(String ID_Rol) {
        String sql = "DELETE FROM roles WHERE ID_Rol = ?";
        return jdbcTemplate.update(sql, ID_Rol);
    }
}