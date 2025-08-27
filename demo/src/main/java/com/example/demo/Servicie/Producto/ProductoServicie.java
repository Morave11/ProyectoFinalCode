package com.example.demo.Servicie.Producto;


import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;
import org.springframework.jdbc.core.RowMapper;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

@Service
public class ProductoServicie {
    @Autowired
    private  JdbcTemplate jdbcTemplate;
    public List<String> ObtenerProductos(){
        String sql = "SELECT  ID_Producto,Nombre_Producto,Descripcion,Precio_Venta,Stock_Minimo,ID_Categoria,ID_Estado,ID_Gama  FROM productos ";
        return jdbcTemplate.query(sql,new RowMapper<String>(){

            @Override
            public String mapRow(ResultSet rs, int rowNum)throws SQLException {
                return rs.getString("ID_Producto") +
                        "       " + rs.getString("Nombre_Producto") +
                        "       " + rs.getString("Descripcion") +
                        "       " + rs.getString("Precio_Venta") +
                        "       " + rs.getString("Stock_Minimo") +
                        "       " + rs.getString("ID_Categoria") +
                        "       " + rs.getString("ID_Estado") +
                        "       " + rs.getString("ID_Gama");
            }
        });

    }
    public  void AgregarProductos(String ID_Producto,String Nombre_Producto,String Descripcion,String Precio_Venta,String Stock_Minimo,String ID_Categoria,String ID_Estado,String ID_Gama){
        String sql = "INSERT INTO productos ( ID_Producto,Nombre_Producto,Descripcion,Precio_Venta,Stock_Minimo,ID_Categoria,ID_Estado,ID_Gama)VALUES (?,?,?,?,?,?,?,?)";
        jdbcTemplate.update(sql,ID_Producto,Nombre_Producto,Descripcion,Precio_Venta,Stock_Minimo,ID_Categoria,ID_Estado,ID_Gama);

    }


    public int actualizarProductos(String ID_Producto, String Nombre_Producto, String Descripcion,String Precio_Venta, String Stock_Minimo, String ID_Categoria, String ID_Estado, String ID_Gama) {
        String sql = "UPDATE productos SET Nombre_Producto = ?, Descripcion = ?, Precio_Venta = ?, Stock_Minimo = ?, ID_Categoria = ?, ID_Estado = ?, ID_Gama = ? WHERE ID_Producto = ?";

        return jdbcTemplate.update(sql, Nombre_Producto, Descripcion, Precio_Venta,Stock_Minimo, ID_Categoria, ID_Estado, ID_Gama, ID_Producto);
    }


    public int EliminarProductos(String ID_Producto) {
        String sql = "DELETE FROM productos WHERE ID_Producto = ?";
        return jdbcTemplate.update(sql, ID_Producto);
    }

}

