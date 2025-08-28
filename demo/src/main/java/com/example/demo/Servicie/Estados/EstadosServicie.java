package com.example.demo.Servicie.Estados;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.stereotype.Service;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

@Service
public class EstadosServicie {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    public List<String> ObtenerEstados() {
        String estados = "SELECT ID_Estado, Nombre_Estado FROM estados";

        return jdbcTemplate.query(estados, new RowMapper<String>() {
            @Override
            public String mapRow(ResultSet rs, int rowNum) throws SQLException {
                return rs.getString("Nombre_Estado") +
                        "     " + rs.getString("ID_Estado");
            }
        });
    }


    public void AgregarEstado(String ID_Estado, String Nombre_Estado) {
        String sql = "INSERT INTO estados (ID_Estado,Nombre_Estado) VALUES (?,?)";
        jdbcTemplate.update(sql, ID_Estado, Nombre_Estado);
    }

    public int ActualizarEstado(String ID_Estados, String Nombre_Estado) {
        String sql= "UPDATE estados SET Nombre_Estado = ? WHERE ID_Estado = ?";
        return jdbcTemplate.update(sql, Nombre_Estado, ID_Estados);
    }

    public int EliminarEstado(String ID_Estado) {
        String sql = "DELETE FROM estados WHERE ID_Estado = ?";
        return jdbcTemplate.update(sql, ID_Estado);
    }

}

