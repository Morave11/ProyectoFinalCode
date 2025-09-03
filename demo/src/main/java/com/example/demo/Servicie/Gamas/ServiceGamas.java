package com.example.demo.Servicie.Gamas;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class ServiceGamas {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    // Obtener todas las gamas
    public List<String> obtenerGamas() {
        String sql = "SELECT ID_Gama, Nombre_Gama FROM Gamas";
        return jdbcTemplate.query(sql, (rs, rowNum) ->
                rs.getString("ID_Gama") + " | " + rs.getString("Nombre_Gama")
        );
    }

    // Insertar una gama
    public void agregarGama(String ID_Gama, String Nombre_Gama) {
        String sql = "INSERT INTO Gamas (ID_Gama, Nombre_Gama) VALUES (?, ?)";
        jdbcTemplate.update(sql, ID_Gama, Nombre_Gama);
    }

    // Actualizar una gama
    public int actualizarGama(String ID_Gama, String Nombre_Gama) {
        String sql = "UPDATE Gamas SET Nombre_Gama=? WHERE ID_Gama=?";
        return jdbcTemplate.update(sql, Nombre_Gama, ID_Gama);
    }

    // Eliminar una gama
    public int eliminarGama(String ID_Gama) {
        String sql = "DELETE FROM Gamas WHERE ID_Gama=?";
        return jdbcTemplate.update(sql, ID_Gama);
    }
}