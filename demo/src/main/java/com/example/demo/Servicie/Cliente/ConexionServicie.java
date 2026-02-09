package com.example.demo.Servicie.Cliente;


import com.example.demo.DTO.Cliente.ClienteDTO;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.dao.EmptyResultDataAccessException;
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


    public List<String>  obtenerClientesDetalles() {
        String detalles = "SELECT Documento_Cliente,Nombre_Cliente,Apellido_Cliente,ID_Estado FROM clientes";
        return jdbcTemplate.query(detalles, new RowMapper<String>() {

            @Override
            public String  mapRow(ResultSet rs, int rowNum) throws SQLException {
                return rs.getString("Documento_Cliente")
                        + "________" + rs.getString("Nombre_Cliente")
                        + "________" + rs.getString("Apellido_Cliente")
                        + "________" + rs.getString("ID_Estado");
            }

        });
    }

    public ClienteDTO buscarClientePorDocumento(String documento) {

        String sql = """
        SELECT Documento_Cliente, Nombre_Cliente, Apellido_Cliente, ID_Estado
        FROM clientes
        WHERE Documento_Cliente = ?
    """;

        try {
            return jdbcTemplate.queryForObject(sql, (rs, rowNum) -> {
                        ClienteDTO dto = new ClienteDTO();
                        dto.setDocumento_Cliente(rs.getString("Documento_Cliente"));
                        dto.setNombre_Cliente(rs.getString("Nombre_Cliente"));
                        dto.setApellido_Cliente(rs.getString("Apellido_Cliente"));
                        dto.setID_Estado(rs.getString("ID_Estado"));
                        return dto;
                    },
                    documento
            );
        } catch (EmptyResultDataAccessException e) {
            return null; // cliente no encontrado
        }
    }

    public void agregarClientes(String Documento_Cliente,String Nombre_Cliente,String Apellido_Cliente,
                                String ID_Estado){
        String sql = "INSERT INTO clientes (Documento_Cliente,Nombre_Cliente,Apellido_Cliente,ID_Estado) VALUES (?,?,?,?)";
        jdbcTemplate.update (sql,Documento_Cliente,Nombre_Cliente,Apellido_Cliente,ID_Estado);
    }


    public int actualizarClientes(String Documento_Cliente, String Nombre_Cliente, String Apellido_Cliente, String ID_Estado) {

        String sql = "UPDATE clientes SET Nombre_Cliente = ?, Apellido_Cliente = ?" +
                " ID_Estado = ? WHERE Documento_Cliente = ?";

        return jdbcTemplate.update(sql, Nombre_Cliente, Apellido_Cliente, ID_Estado, Documento_Cliente);
    }

    public int eliminarClientes(String Documento_Cliente) {
        String sql = "DELETE FROM clientes WHERE Documento_Cliente = ?";
        return jdbcTemplate.update(sql, Documento_Cliente);
    }

}

