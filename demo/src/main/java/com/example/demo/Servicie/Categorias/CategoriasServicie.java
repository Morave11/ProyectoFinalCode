package com.example.demo.Servicie.Categorias;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.stereotype.Service;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

@Service
public class CategoriasServicie {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    public List<String> ObtenerCategorias() {
        String sql = "SELECT ID_Categoria, Nombre_Categoria FROM categorias";

        return jdbcTemplate.query(sql, new RowMapper<String>() {
            @Override
            public String mapRow(ResultSet rs, int rowNum) throws SQLException {
                return rs.getString("Nombre_Categoria") +
                        "     " + rs.getString("ID_Categoria");
            }
        });
    }


    public void AgregarCategoria(String ID_Categoria, String Nombre_Categoria) {
        String sql = "INSERT INTO categorias (ID_Categoria,Nombre_Categoria) VALUES (?,?)";
        jdbcTemplate.update(sql, ID_Categoria, Nombre_Categoria);
    }

    public int ActualizarCategoria(String ID_Categoria, String Nombre_Categoria) {
        String sql= "UPDATE categorias SET Nombre_Categoria = ? WHERE ID_Categoria = ?";
        return jdbcTemplate.update(sql, Nombre_Categoria, ID_Categoria);
    }

    public int EliminarCategoria(String ID_Categoria) {
        String sql = "DELETE FROM categorias WHERE ID_Categoria = ?";
        return jdbcTemplate.update(sql, ID_Categoria);
    }

}