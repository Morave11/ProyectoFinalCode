package com.example.demo.Servicie.Cliente;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;
import org.springframework.jdbc.core.RowMapper;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

@Service
public class ConexionServicie {
    @Autowired
    private  JdbcTemplate jdbcTemplate;


    public List<String> obtenerClientes(){
        String clientes = "select  Nombre_Cliente from clientes";
        return jdbcTemplate.query(clientes,new RowMapper<String>(){

            @Override
            public String mapRow(ResultSet rs,int rowNum)throws SQLException{
                return rs.getString("Nombre_Cliente");
            }
        });
    }
    public List<String>  obtenerClientesDetalles() {
        String detalles = "SELECT Documento_Cliente,Nombre_Cliente,Apellido_Cliente,Telefono,Fecha_Nacimiento,Genero,ID_Estado FROM clientes";
        return jdbcTemplate.query(detalles, new RowMapper<String>() {

            @Override
            public String  mapRow(ResultSet rs, int rowNum) throws SQLException {
                return rs.getString("Documento_Cliente")
                        + "________" + rs.getString("Nombre_Cliente")
                        + "________" + rs.getString("Apellido_Cliente")
                        + "________" + rs.getString("Telefono")
                        + "________" + rs.getString("Fecha_Nacimiento")
                        + "________" + rs.getString("Genero")
                        + "________" + rs.getString("ID_Estado");
            }

        });
    }

    public void agregarClientes(String Documento_Cliente,String Nombre_Cliente,String Apellido_Cliente,
                                String Telefono,String Fecha_Nacimiento,String Genero, String ID_Estado){
        String sql = "INSERT INTO clientes (Documento_Cliente,Nombre_Cliente,Apellido_Cliente,Telefono,Fecha_Nacimiento,Genero,ID_Estado) VALUES (?,?,?,?,?,?,?)";
        jdbcTemplate.update (sql,Documento_Cliente,Nombre_Cliente,Apellido_Cliente,Telefono,Fecha_Nacimiento,Genero,ID_Estado);
    }


    public int actualizarClientes(String Documento_Cliente, String Nombre_Cliente, String Apellido_Cliente, String Telefono,
                                  String Fecha_Nacimiento, String Genero, String ID_Estado) {

        String sql = "UPDATE clientes SET Nombre_Cliente = ?, Apellido_Cliente = ?, Telefono = ?, Fecha_Nacimiento = ?, Genero = ?," +
                " ID_Estado = ? WHERE Documento_Cliente = ?";

        return jdbcTemplate.update(sql, Nombre_Cliente, Apellido_Cliente, Telefono, Fecha_Nacimiento, Genero, ID_Estado, Documento_Cliente);
    }

    public int eliminarClientes(String Documento_Cliente) {
        String sql = "DELETE FROM clientes WHERE Documento_Cliente = ?";
        return jdbcTemplate.update(sql, Documento_Cliente);
    }

}

