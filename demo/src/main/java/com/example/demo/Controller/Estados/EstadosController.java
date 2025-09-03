package com.example.demo.Controller.Estados;

import com.example.demo.DTO.Estados.EstadosDTO;
import com.example.demo.DTO.Gamas.GamasDTO;
import com.example.demo.Servicie.Estados.EstadosServicie;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class EstadosController {

    @Autowired
    private EstadosServicie estadosServicie;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/Estado")
   public List<String> ObtenerEstados(){
        return estadosServicie.ObtenerEstados();
    }

    @PostMapping("/RegristraEstado")
    public String AgregarEstado(@RequestBody EstadosDTO estadosDTO){
        estadosServicie.AgregarEstado(
                estadosDTO.getID_Estado(),
                estadosDTO.getNombre_Estado()
        );
        return "Estado registrada correctamente";
    }

    @PutMapping("/ActualizaEstado/{ID_Estado}")
    public String ActualizarEstado(@PathVariable("ID_Estado") String ID_Estado, @RequestBody EstadosDTO estadosDTO){
        int filas = estadosServicie.ActualizarEstado(
                ID_Estado,
                estadosDTO.getNombre_Estado()
        );
    return "El Estado se actualizo correctamente";
    }

    @DeleteMapping("/EliminarEstado/{ID_Estado}")
    public String ElimninarEstado(@PathVariable String ID_Estado){
        int filas = estadosServicie.EliminarEstado (ID_Estado);

    return "El Estado se elimino correctamente";
    }
}




