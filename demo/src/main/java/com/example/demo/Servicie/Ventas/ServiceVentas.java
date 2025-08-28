package com.example.demo.Servicie.Ventas;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class ServiceVentas {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    // Obtener todas las ventas
    public List<String> obtenerVentas() {
        String sql = "SELECT ID_Venta, Documento_Cliente, Documento_Empleado FROM Ventas";
        return jdbcTemplate.query(sql, (rs, rowNum) ->
                rs.getString("ID_Venta") + " | Cliente: " + rs.getString("Documento_Cliente") +
                        " | Empleado: " + rs.getString("Documento_Empleado")
        );
    }

    // Insertar una venta
    public void agregarVenta(String ID_Venta, String Documento_Cliente, String Documento_Empleado) {
        String sql = "INSERT INTO Ventas (ID_Venta, Documento_Cliente, Documento_Empleado) VALUES (?,?,?)";
        jdbcTemplate.update(sql, ID_Venta, Documento_Cliente, Documento_Empleado);
    }

    // Actualizar una venta
    public int actualizarVenta(String ID_Venta, String Documento_Cliente, String Documento_Empleado) {
        String sql = "UPDATE Ventas SET Documento_Cliente=?, Documento_Empleado=? WHERE ID_Venta=?";
        return jdbcTemplate.update(sql, Documento_Cliente, Documento_Empleado, ID_Venta);
    }

    // Eliminar una venta
    public int eliminarVenta(String ID_Venta) {
        String sql = "DELETE FROM Ventas WHERE ID_Venta=?";
        return jdbcTemplate.update(sql, ID_Venta);
    }
}