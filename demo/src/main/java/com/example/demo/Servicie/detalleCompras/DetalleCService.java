package com.example.demo.Servicie.detalleCompras;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.stereotype.Service;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

@Service
public class DetalleCService {
    @Autowired
    private JdbcTemplate jdbcTemplate;

    public List<String> obtenerDetalleC() {
        String DetalleCompra = "SELECT ID_Entrada,ID_Proveedor,Cantidad,Fecha_Entrada FROM detalle_compras";
        return jdbcTemplate.query(DetalleCompra, new RowMapper<String>() {

            @Override
            public String  mapRow(ResultSet rs, int rowNum) throws SQLException {
                return rs.getString("ID_Entrada")
                        + "________" + rs.getString("ID_Proveedor")
                        + "________" + rs.getString("Cantidad")
                        + "________" + rs.getString("Fecha_Entrada");
            }

        });
    }

    public void agregarDetalleC(String ID_Entrada, String ID_Proveedor, int Cantidad, String Fecha_Entrada){
        String sql = "INSERT INTO detalle_compras (ID_Entrada,ID_Proveedor,Cantidad,Fecha_Entrada) VALUES (?,?,?,?)";
        jdbcTemplate.update (sql,ID_Entrada, ID_Proveedor, Cantidad, Fecha_Entrada);
    }

    public int actualizarDetalleC(String ID_Entrada, String ID_Proveedor, int Cantidad, String Fecha_Entrada) {

        String sql = "UPDATE detalle_compras SET Cantidad = ? WHERE ID_Entrada = ? AND ID_Proveedor =  ?";

        return jdbcTemplate.update(sql, Cantidad, ID_Proveedor, ID_Entrada, Fecha_Entrada);
    }

    public int eliminarDevolucionC(String ID_Entrada, String ID_Proveedor) {
        String sql = "DELETE FROM detalle_compras WHERE ID_Entrada = ? AND ID_Proveedor = ?";
        return jdbcTemplate.update(sql, ID_Entrada, ID_Proveedor);
    }

}