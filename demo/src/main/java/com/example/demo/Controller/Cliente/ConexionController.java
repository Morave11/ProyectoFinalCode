package com.example.demo.Controller.Cliente;


import com.example.demo.DTO.Cliente.ClienteDTO;
import com.example.demo.Servicie.Cliente.ConexionServicie;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@Tag(name = "Cliente", description = "Operaciones sobre la tabla Clientes")
public class ConexionController {
    @Autowired
    private ConexionServicie conexionServicie;
    @Autowired
    private JdbcTemplate jdbcTemplate;

    @GetMapping("/Detalles")
    @Operation(summary = "Obtener Clientes",
            description = "Devuelve una lista con todos los clientes almacenados en la tabla Clientes.")
    public List<String> obtenerClientesDetalles() {
        return conexionServicie.obtenerClientesDetalles();}

    @PostMapping("/RegistraC")
    @Operation(summary = "Registrar un nuevo cliente",
            description = "Crea un nuevo cliente en la tabla Clientes a partir de los datos enviados en el cuerpo de la petición.")
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

    @PutMapping("/ActualizarC/{Documento_Cliente}")
    @Operation(summary = "Actualizar un cliente existente",
            description = "Modifica los datos de un cliente según el ID proporcionado en la URL.")
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

    @DeleteMapping("/EliminarC/{Documento_Cliente}")
    @Operation(summary = "Eliminar un cliente",
            description = "Elimina de forma permanente el cliente que coincide con el ID proporcionado.")
    public String eliminarClientes(@PathVariable String Documento_Cliente) {
        int filas = conexionServicie.eliminarClientes (Documento_Cliente);

        return   "Cliente eliminado correctamente" ;
    }

}
