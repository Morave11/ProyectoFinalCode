package com.example.demo.Servicie.Devoluciones;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.stereotype.Service;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

@Service
public class DevolucionService {
    @Autowired
    private JdbcTemplate jdbcTemplate;

    public List<String>  obtenerDevolucion() {
        String DevolucionC = "SELECT ID_Devolucion,Fecha_Devolucion,Motivo FROM devoluciones";
        return jdbcTemplate.query(DevolucionC, new RowMapper<String>() {

            @Override
            public String  mapRow(ResultSet rs, int rowNum) throws SQLException {
                return rs.getString("ID_Devolucion")
                        + "________" + rs.getString("Fecha_Devolucion")
                        + "________" + rs.getString("Motivo");
            }

        });
    }

    public void agregarDevolucion(String ID_Devolucion, String Fecha_Devolucion, String Motivo){
        String sql = "INSERT INTO devoluciones (ID_Devolucion,Fecha_Devolucion,Motivo) VALUES (?,?,?)";
        jdbcTemplate.update (sql,ID_Devolucion, Fecha_Devolucion, Motivo);
    }

    public int actualizarDevolucion(String ID_Devolucion, String Fecha_Devolucion, String Motivo) {

        String sql = "UPDATE devoluciones SET Fecha_Devolucion = ?, Motivo = ? WHERE ID_Devolucion = ?";

        return jdbcTemplate.update(sql, Fecha_Devolucion, Motivo, ID_Devolucion);
    }

    public int eliminarDevolucion(String ID_Devolucion) {
        String sql = "DELETE FROM devoluciones WHERE ID_Devolucion = ?";
        return jdbcTemplate.update(sql, ID_Devolucion);
    }

}
