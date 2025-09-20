package com.example.demo.Servicie.Compras;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class ComprasServicie {

    @Autowired
    private JdbcTemplate jdbcTemplate;


    public List<String> obtenerCompras() {
        String sql = "SELECT ID_Entrada, Precio_Compra, ID_Producto, Documento_Empleado FROM Compras";
        return jdbcTemplate.query(sql, (rs, rowNum) ->
                rs.getString("ID_Entrada") + "________" +
                        rs.getString("Precio_Compra") + "________" +
                        rs.getString("ID_Producto") + "________" +
                        rs.getString("Documento_Empleado")
        );
    }


    public void agregarCompra(String ID_Entrada, String Precio_Compra, String ID_Producto, String Documento_Empleado) {
        String sql = "INSERT INTO Compras (ID_Entrada, Precio_Compra, ID_Producto, Documento_Empleado) VALUES (?,?,?,?)";
        jdbcTemplate.update(sql, ID_Entrada, Precio_Compra, ID_Producto, Documento_Empleado);
    }


    public int actualizarCompra(String ID_Entrada, String Precio_Compra, String ID_Producto, String Documento_Empleado) {
        String sql = "UPDATE Compras SET Precio_Compra = ?, ID_Producto = ?, Documento_Empleado = ? WHERE ID_Entrada = ?";
        return jdbcTemplate.update(sql, Precio_Compra, ID_Producto, Documento_Empleado, ID_Entrada);
    }

    // ELIMINAR
    public int eliminarCompra(String ID_Entrada) {
        String sql = "DELETE FROM Compras WHERE ID_Entrada = ?";
        return jdbcTemplate.update(sql, ID_Entrada);
    }
}