package com.example.demo.Servicie.Compras;

import com.example.demo.DTO.Compras.ComprasDTO;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.stereotype.Service;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

@Service
public class ComprasServicie {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    public List<String> ObtenerCompras() {
        String compras = "SELECT ID_Entrada, Precio_Compra, ID_Producto, Documento_EMpleado FROM compras";
        return jdbcTemplate.query(compras, new RowMapper<String>() {
            @Override
            public String mapRow(ResultSet rs, int rowNum) throws SQLException {
                return rs.getString("ID_Entrada")+
                        "    " + rs.getString("Precio_Compra")+
                        "    " + rs.getString("ID_Producto")+
                        "    " + rs.getString("Documento_EMpleado");
            }
        });
    }

    public void AgregarCompra(String ID_Entrada, String Precio_Compra, String ID_Producto, String Documento_EMpleado) {
        String sql = "INSERT INTO compras (ID_Entrada, Precio_Compra, ID_Producto, Documento_EMpleado) VALUES (?, ?, ?, ?)";
        jdbcTemplate.update(sql, ID_Entrada, Precio_Compra, ID_Producto, Documento_EMpleado);
    }

    public int ActualizarCompra(String ID_Entrada, String Precio_Compra, String ID_Producto, String Documento_EMpleado) {
        String sql = "UPDATE compras SET Precio_Compra = ?, ID_Producto = ?, Documento_EMpleado = ? WHERE ID_Entrada = ?";
        return jdbcTemplate.update(sql, Precio_Compra, ID_Producto, Documento_EMpleado, ID_Entrada);
    }

    public int EliminarCompra(String ID_Entrada) {
        String sql = "DELETE FROM compras WHERE ID_Entrada = ?";
        return jdbcTemplate.update(sql, ID_Entrada);
    }
}

