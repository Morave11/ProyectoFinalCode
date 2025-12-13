package com.example.demo.Controller.Gamas;

import com.example.demo.DTO.Gamas.GamasDTO;
import com.example.demo.Servicie.Gamas.ServiceGamas;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@Tag(name = "Gamas", description = "Operaciones sobre la tabla gamas")
public class ControllerGamas {

    @Autowired
    private ServiceGamas serviceGamas;

    @GetMapping("/Gamas")
    @Operation(summary = "Obtener Gamas",
            description = "Devuelve una lista con todas las gamas almacenados en la tabla gamas.")
    public List<String> obtenerGamas() {
        return serviceGamas.obtenerGamas();
    }

    @PostMapping("/GamasRegistro")
    @Operation(summary = "Registrar una nueva gama",
            description = "Crea una nueva gama en la tabla gama a partir de los datos enviados en el cuerpo de la petición.")
    public String agregarGama(@RequestBody GamasDTO gamaDTO) {
        serviceGamas.agregarGama
                (gamaDTO.getID_Gama(),
                        gamaDTO.getNombre_Gama());
        return "Gama registrada correctamente";
    }

    @PutMapping("/GamasActualizar/{ID_Gama}")
    @Operation(summary = "Actualizar una gama existente",
            description = "Modifica los datos de una gama según el ID proporcionado en la URL.")
    public String actualizarGama(@PathVariable String ID_Gama, @RequestBody GamasDTO gamaDTO) {
        int filas = serviceGamas.actualizarGama
                (ID_Gama,
                        gamaDTO.getNombre_Gama());
        return filas > 0 ? "Gama actualizada correctamente" : "Error al actualizar gama";
    }

    @DeleteMapping("/GamasEliminar/{ID_Gama}")
    @Operation(summary = "Eliminar una Gama",
            description = "Elimina de forma permanente la gama que coincide con el ID proporcionado.")
    public String eliminarGama(@PathVariable String ID_Gama) {
        int filas = serviceGamas.eliminarGama(ID_Gama);
        return filas > 0 ? "Gama eliminada correctamente" : "Error al eliminar gama";
    }
}