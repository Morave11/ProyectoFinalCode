package com.example.demo.Servicie.detalleDevolucion;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.stereotype.Service;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

@Service
public class DetalleDService {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    public List<String> obtenerDetalleD() {
        String sql = "SELECT ID_Devolucion, Cantidad_Devuelta, ID_Venta FROM detalle_devoluciones";
        return jdbcTemplate.query(sql, new RowMapper<String>() {
            @Override
            public String mapRow(ResultSet rs, int rowNum) throws SQLException {
                return rs.getString("ID_Devolucion")
                        + "________" + rs.getString("Cantidad_Devuelta")
                        + "________" + rs.getString("ID_Venta");
            }
        });
    }

    public void agregarDetalleD(String ID_Devolucion, int Cantidad_Devuelta, String ID_Venta) {
        String sql = "INSERT INTO detalle_devoluciones (ID_Devolucion, Cantidad_Devuelta, ID_Venta) VALUES (?, ?, ?)";
        jdbcTemplate.update(sql, ID_Devolucion, Cantidad_Devuelta, ID_Venta);
    }

    // ⚠️ Ahora usa la clave compuesta en el WHERE
    public int actualizarDetalleD(String ID_Devolucion, String ID_Venta, int Cantidad_Devuelta) {
        String sql = "UPDATE detalle_devoluciones " +
                "SET Cantidad_Devuelta = ? " +
                "WHERE ID_Devolucion = ? AND ID_Venta = ?";
        return jdbcTemplate.update(sql, Cantidad_Devuelta, ID_Devolucion, ID_Venta);
    }

    // ⚠️ También borra por la clave compuesta
    public int eliminarDevolucionD(String ID_Devolucion, String ID_Venta) {
        String sql = "DELETE FROM detalle_devoluciones WHERE ID_Devolucion = ? AND ID_Venta = ?";
        return jdbcTemplate.update(sql, ID_Devolucion, ID_Venta);
    }
}