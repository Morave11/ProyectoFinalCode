package com.example.demo.Servicie.Proveedor;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.stereotype.Service;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

@Service
public class ServicieProveedor {
    @Autowired
    private static JdbcTemplate jdbcTemplate;

    public List<String> ObtenerProveedores(){
        String provedores = "select  ID_Proveedor, Nombre_Proveedor,  Correo_Electronico,Telefono,ID_Estado from proveedores";
        return jdbcTemplate.query(provedores,new RowMapper<String>(){

            @Override
            public String mapRow(ResultSet rs, int rowNum)throws SQLException {
                return rs.getString("ID_Proveedor") +
                        "      "+rs.getString("Nombre_Proveedor") +
                        "      "+rs.getString("Correo_Electronico")+
                        "      "+rs.getString("Telefono")+
                        "      "+rs.getString("ID_Estado");
            }
        });
    }
    public  void agregaProveedores(String ID_Proveedor,String Nombre_Proveedor, String Correo_Electronico,String Telefono,String ID_Estado){
        String sql = "INSERT INTO proveedores (ID_Proveedor,Nombre_Proveedor,Correo_Electronico,Telefono,ID_Estado)VALUES (?,?,?,?,?)";
        jdbcTemplate.update(sql,ID_Proveedor,Nombre_Proveedor,Correo_Electronico,Telefono,ID_Estado);

    }


    public int ActualizaProveedores(String ID_Proveedor,String Nombre_Proveedor, String Correo_Electronico,String Telefono,String ID_Estado) {
        String sql = "UPDATE proveedores SET Nombre_Proveedor = ?, Correo_Electronico = ?, Telefono = ?, ID_Estado = ? WHERE ID_Proveedor = ?";

        return jdbcTemplate.update(sql, Nombre_Proveedor,Correo_Electronico,Telefono,ID_Estado,ID_Proveedor);
    }

    public int EliminarProveedor(String ID_Proveedor) {
        String sql = "DELETE FROM proveedores WHERE Documento_Cliente = ?";
        return jdbcTemplate.update(sql, ID_Proveedor);
    }
}



