package com.example.demo.Controller.Estados;

import com.example.demo.DTO.Estados.EstadosDTO;
import com.example.demo.DTO.Gamas.GamasDTO;
import com.example.demo.Servicie.Estados.EstadosServicie;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@Tag(name = "Estados", description = "Operaciones sobre la tabla estados")
public class EstadosController {

    @Autowired
    private EstadosServicie estadosServicie;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/Estado")
    @Operation(summary = "Obtener Estados",
            description = "Devuelve una lista con todos los estados almacenados en la tabla estados.")
    public List<String> ObtenerEstados(){
        return estadosServicie.ObtenerEstados();
    }

    @PostMapping("/RegristraEstado")
    @Operation(summary = "Registrar un nuevo estado",
            description = "Crea un nuevo estado en la tabla estado a partir de los datos enviados en el cuerpo de la petición.")
    public String AgregarEstado(@RequestBody EstadosDTO estadosDTO){
        estadosServicie.AgregarEstado(
                estadosDTO.getID_Estado(),
                estadosDTO.getNombre_Estado()
        );
        return "Estado registrada correctamente";
    }

    @PutMapping("/ActualizaEstado/{ID_Estado}")
    @Operation(summary = "Actualizar un Estado existente",
            description = "Modifica los datos de un estado según el ID proporcionado en la URL.")
    public String ActualizarEstado(@PathVariable("ID_Estado") String ID_Estado, @RequestBody EstadosDTO estadosDTO){
        int filas = estadosServicie.ActualizarEstado(
                ID_Estado,
                estadosDTO.getNombre_Estado()
        );
    return "El Estado se actualizo correctamente";
    }

    @DeleteMapping("/EliminarEstado/{ID_Estado}")
    @Operation(summary = "Eliminar un Estado",
            description = "Elimina de forma permanente el estado que coincide con el ID proporcionado.")
    public String ElimninarEstado(@PathVariable String ID_Estado){
        int filas = estadosServicie.EliminarEstado (ID_Estado);

    return "El Estado se elimino correctamente";
    }
}




