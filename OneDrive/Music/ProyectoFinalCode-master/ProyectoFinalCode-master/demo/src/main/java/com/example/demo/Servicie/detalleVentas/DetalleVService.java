package com.example.demo.Servicie.detalleVentas;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.stereotype.Service;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

@Service
public class DetalleVService {
    @Autowired
    private JdbcTemplate jdbcTemplate;

    public List<String> obtenerDetalleV() {
        String DetalleVentas = "SELECT ID_Venta,ID_Producto,Fecha_Salida,Cantidad FROM detalle_ventas";
        return jdbcTemplate.query(DetalleVentas, new RowMapper<String>() {

            @Override
            public String  mapRow(ResultSet rs, int rowNum) throws SQLException {
                return rs.getString("ID_Venta")
                        + "________" + rs.getString("ID_Producto")
                        + "________" + rs.getString("Cantidad")
                        + "________" + rs.getString("Fecha_Salida");
            }

        });
    }

    public void agregarDetalleV(String ID_Venta, String ID_Producto, int Cantidad, String Fecha_Salida){
        String sql = "INSERT INTO detalle_ventas (ID_Venta,ID_Producto,Cantidad,Fecha_Salida) VALUES (?,?,?,?)";
        jdbcTemplate.update (sql,ID_Venta, ID_Producto, Cantidad, Fecha_Salida);
    }

    public int actualizarDetalleV(String ID_Venta, String ID_Producto, int Cantidad) {

        String sql = "UPDATE detalle_ventas SET Cantidad = ? WHERE ID_Venta = ? AND ID_Producto = ?";

        return jdbcTemplate.update(sql, Cantidad, ID_Producto, ID_Venta);
    }

    public int eliminarDevolucionV(String ID_Venta, String ID_Producto) {
        String sql = "DELETE FROM detalle_ventas WHERE ID_Venta = ? AND ID_Producto = ?";
        return jdbcTemplate.update(sql, ID_Venta, ID_Producto);
    }

}