package com.example.demo.Controller.Cliente;


import com.example.demo.DTO.Cliente.ClienteDTO;
import com.example.demo.Servicie.Cliente.ConexionServicie;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class ConexionController {
    @Autowired
    private ConexionServicie conexionServicie;
    @Autowired
    private JdbcTemplate jdbcTemplate;

    @GetMapping("/Usuarios")
    public List<String> obtenerClientes(){
        return conexionServicie.obtenerClientes();
    }

    @GetMapping("/Detalles")
    public List<String> obtenerClientesDetalles() {
        return conexionServicie.obtenerClientesDetalles();}



    @PostMapping("/Registra")
    public String agregarClientes(@RequestBody ClienteDTO cliente) {
        conexionServicie.agregarClientes(
                cliente.getDocumento_Cliente(),
                cliente.getNombre_Cliente(),
                cliente.getApellido_Cliente(),
                cliente.getTelefono(),
                cliente.getFecha_Nacimiento(),
                cliente.getGenero(),
                cliente.getID_Estado()
        );
        return "Cliente esta registrado correctamente";
    }
    @PutMapping("/Actualizar/{Documento_Cliente}")
    public String actualizarClientes(@PathVariable("Documento_Cliente") String Documento_Cliente, @RequestBody ClienteDTO clienteDTO) {
        int filas = conexionServicie.actualizarClientes(
                Documento_Cliente,
                clienteDTO.getNombre_Cliente(),
                clienteDTO.getApellido_Cliente(),
                clienteDTO.getTelefono(),
                clienteDTO.getFecha_Nacimiento(),
                clienteDTO.getGenero(),
                clienteDTO.getID_Estado()
        );

        return   "Cliente actualizado correctamente" ;
    }


    @DeleteMapping("/Eleminar/{Documento_Cliente}")
    public String eliminarClientes(@PathVariable String Documento_Cliente) {
        int filas = conexionServicie.eliminarClientes (Documento_Cliente);

        return   "Cliente eliminado correctamente" ;
    }


}
