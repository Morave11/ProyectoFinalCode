package com.example.demo.Servicie.Contraseñas;

import com.example.demo.DTO.Contraseñas.ContraseñaDTO;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.stereotype.Service;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

@Service
public class ContraseñaServicie {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    public List<String> ObtenerContraseñas() {
        String contrasena = "SELECT ID_Contrasena, Documento_Empleado, Contrasena_Hash, Fecha_Creacion FROM contrasenas";

        return jdbcTemplate.query(contrasena, new RowMapper<String>() {
            @Override
            public String mapRow(ResultSet rs, int rowNum) throws SQLException {
                return rs.getString("ID_Contrasena") +
                        "________" + rs.getString("Documento_Empleado") +
                        "________" + rs.getString("Contrasena_Hash") +
                        "________" + rs.getString("Fecha_Creacion");
            }
        });
    }

    public void AgregarContrasena(String ID_Contrasena, String Documento_Empleado, String Contrasena_Hash, String Fecha_Creacion) {
        String sql = "INSERT INTO contrasenas (ID_Contrasena, Documento_Empleado, Contrasena_Hash, Fecha_Creacion) VALUES (?, ?, ?, ?)";
        jdbcTemplate.update(sql, ID_Contrasena, Documento_Empleado, Contrasena_Hash, Fecha_Creacion);
    }

    public int ActualizarContrasena(String ID_Contrasena, String Documento_Empleado, String Contrasena_Hash, String Fecha_Creacion) {
        String sql = "UPDATE contrasenas SET Documento_Empleado = ?, Contrasena_Hash = ? , Fecha_Creacion = ? WHERE ID_Contrasena = ?";
        return jdbcTemplate.update(sql, Documento_Empleado, Contrasena_Hash, Fecha_Creacion, ID_Contrasena);
    }

    public int EliminarContrasena(String ID_Contrasena) {
        String sql = "DELETE FROM contrasenas WHERE ID_Contrasena = ?";
        return jdbcTemplate.update(sql, ID_Contrasena);
    }

    public boolean validarLogin(String documentoEmpleado, String contrasenaPlano) {


        String sql = "SELECT COUNT(*) FROM contrasenas " +
                "WHERE Documento_Empleado = ? " +
                "AND Contrasena_Hash = SHA2(?, 256)";

        Integer count = jdbcTemplate.queryForObject(
                sql,
                Integer.class,
                documentoEmpleado,
                contrasenaPlano
        );

        return count != null && count > 0;
    }
}
