package com.example.demo.Servicie.Ventas;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
public class ServiceVentas {

    @Autowired
    private JdbcTemplate jdbcTemplate;


    public List<String> obtenerVentas() {
        String sql = "SELECT ID_Venta, Documento_Cliente, Documento_Empleado FROM Ventas";
        return jdbcTemplate.query(sql, (rs, rowNum) ->
                rs.getString("ID_Venta")
                        + "________"
                        + rs.getString("Documento_Cliente") +
                        "________"
                        + rs.getString("Documento_Empleado")
        );
    }


    public void agregarVenta(String Documento_Cliente, String Documento_Empleado) {
        String sql = "INSERT INTO ventas (Documento_Cliente, Documento_Empleado) VALUES (?, ?)";
        jdbcTemplate.update(sql, Documento_Cliente, Documento_Empleado);
    }


    public int actualizarVenta(String ID_Venta, String Documento_Cliente, String Documento_Empleado) {
        String sql = "UPDATE Ventas SET Documento_Cliente=?, Documento_Empleado=? WHERE ID_Venta=?";
        return jdbcTemplate.update(sql, Documento_Cliente, Documento_Empleado, ID_Venta);
    }

    public int eliminarVenta(String ID_Venta) {
        String sql = "DELETE FROM Ventas WHERE ID_Venta=?";
        return jdbcTemplate.update(sql, ID_Venta);
    }
}