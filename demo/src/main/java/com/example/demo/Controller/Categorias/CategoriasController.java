package com.example.demo.Controller.Categorias;

import com.example.demo.DTO.Categorias.CategoriasDTO;
import com.example.demo.DTO.Estados.EstadosDTO;
import com.example.demo.DTO.Gamas.GamasDTO;
import com.example.demo.Servicie.Categorias.CategoriasServicie;
import com.example.demo.Servicie.Estados.EstadosServicie;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class CategoriasController {

    @Autowired
    private CategoriasServicie categoriasServicie;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/Categorias")
    public List<String> ObtenerCategorias(){
        return categoriasServicie.ObtenerCategorias();
    }

    @PostMapping("/RegristraCategoria")
    public String AgregarCategoria(@RequestBody CategoriasDTO categoriasDTO){
        categoriasServicie.ActualizarCategoria(
                categoriasDTO.getID_Categoria(),
                categoriasDTO.getNombre_Categoria()
        );
        return "Categoria registrada correctamente";
    }

    @PutMapping("/ActualizaCategoria/{ID_Categoria}")
    public String ActualizarCategoria(@PathVariable("ID_Categoria") String ID_Categoria, @RequestBody CategoriasDTO categoriasDTO){
        int filas = categoriasServicie.ActualizarCategoria(
                ID_Categoria,
                categoriasDTO.getNombre_Categoria()
        );
        return "La categoria se actualizo correctamente";
    }

    @DeleteMapping("/EliminarCategoria/{ID_Categoria}")
    public String EliminarCategoria(@PathVariable String ID_Categoria){
        int filas = categoriasServicie.EliminarCategoria (ID_Categoria);

        return "La categoria se elimino correctamente";
    }
}