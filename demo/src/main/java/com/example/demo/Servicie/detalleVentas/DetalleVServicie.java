package com.example.demo.Servicie.detalleVentas;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class DetalleVServicie {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    // Listar todos los detalles de ventas
    public List<String> obtenerDetalleVentas() {
        String sql = "SELECT Cantidad, Fecha_Salida, ID_Producto, ID_Venta FROM Detalle_Ventas";
        return jdbcTemplate.query(sql, (rs, rowNum) ->
                rs.getInt("Cantidad") + " | " +
                        rs.getString("Fecha_Salida") + " | " +
                        rs.getString("ID_Producto") + " | " +
                        rs.getString("ID_Venta")
        );
    }

    // Insertar un detalle de venta
    public void agregarDetalleVenta(int Cantidad, String Fecha_Salida, String ID_Producto, String ID_Venta) {
        String sql = "INSERT INTO Detalle_Ventas (Cantidad, Fecha_Salida, ID_Producto, ID_Venta) VALUES (?, ?, ?, ?)";
        jdbcTemplate.update(sql, Cantidad, Fecha_Salida, ID_Producto, ID_Venta);
    }

    // Actualizar un detalle de venta
    public int actualizarDetalleVenta(String ID_Producto, String ID_Venta, int Cantidad, String Fecha_Salida) {
        String sql = "UPDATE Detalle_Ventas SET Cantidad=?, Fecha_Salida=? WHERE ID_Producto=? AND ID_Venta=?";
        return jdbcTemplate.update(sql, Cantidad, Fecha_Salida, ID_Producto, ID_Venta);
    }

    // Eliminar un detalle de venta
    public int eliminarDetalleVenta(String ID_Producto, String ID_Venta) {
        String sql = "DELETE FROM Detalle_Ventas WHERE ID_Producto=? AND ID_Venta=?";
        return jdbcTemplate.update(sql, ID_Producto, ID_Venta);
    }
}