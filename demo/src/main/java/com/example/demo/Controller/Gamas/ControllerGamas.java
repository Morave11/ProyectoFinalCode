package com.example.demo.Controller.Gamas;

import com.example.demo.DTO.Gamas.GamasDTO;
import com.example.demo.Servicie.Gamas.ServiceGamas;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class ControllerGamas {

    @Autowired
    private ServiceGamas serviceGamas;

    @GetMapping("/Gamas")
    public List<String> obtenerGamas() {
        return serviceGamas.obtenerGamas();
    }

    @PostMapping("/GamasRegistro")
    public String agregarGama(@RequestBody GamasDTO gamaDTO) {
        serviceGamas.agregarGama
                (gamaDTO.getID_Gama(),
                        gamaDTO.getNombre_Gama());
        return "Gama registrada correctamente";
    }

    @PutMapping("/GamasActualizar/{ID_Gama}")
    public String actualizarGama(@PathVariable String ID_Gama, @RequestBody GamasDTO gamaDTO) {
        int filas = serviceGamas.actualizarGama
                (ID_Gama,
                        gamaDTO.getNombre_Gama());
        return filas > 0 ? "Gama actualizada correctamente" : "Error al actualizar gama";
    }

    @DeleteMapping("/GamasEliminar/{ID_Gama}")
    public String eliminarGama(@PathVariable String ID_Gama) {
        int filas = serviceGamas.eliminarGama(ID_Gama);
        return filas > 0 ? "Gama eliminada correctamente" : "Error al eliminar gama";
    }
}