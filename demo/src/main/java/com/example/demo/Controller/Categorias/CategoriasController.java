package com.example.demo.Controller.Categorias;

import com.example.demo.DTO.Categorias.CategoriasDTO;
import com.example.demo.DTO.Estados.EstadosDTO;
import com.example.demo.DTO.Gamas.GamasDTO;
import com.example.demo.Servicie.Categorias.CategoriasServicie;
import com.example.demo.Servicie.Estados.EstadosServicie;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@Tag(name = "Categorias", description = "Operaciones sobre la tabla Categorias")
public class CategoriasController {

    @Autowired
    private CategoriasServicie categoriasServicie;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/Categorias")
    @Operation(summary = "Obtener Categorias",
            description = "Devuelve una lista con todos las categorias almacenados en la tabla Categorias.")
    public List<String> ObtenerCategorias(){
        return categoriasServicie.ObtenerCategorias();
    }

    @PostMapping("/RegistraCategoria")
    @Operation(summary = "Registrar una nueva categoria",
            description = "Crea un nueva categoria en la tabla Roles a partir de los datos enviados en el cuerpo de la petición.")
    public String AgregarCategoria(@RequestBody CategoriasDTO categoriasDTO){
        categoriasServicie.ActualizarCategoria(
                categoriasDTO.getID_Categoria(),
                categoriasDTO.getNombre_Categoria()
        );
        return "Categoria registrada correctamente";
    }

    @PutMapping("/ActualizaCategoria/{ID_Categoria}")
    @Operation(summary = "Actualizar una categoria existente",
            description = "Modifica los datos de una categoria según el ID proporcionado en la URL.")
    public String ActualizarCategoria(@PathVariable("ID_Categoria") String ID_Categoria, @RequestBody CategoriasDTO categoriasDTO){
        int filas = categoriasServicie.ActualizarCategoria(
                ID_Categoria,
                categoriasDTO.getNombre_Categoria()
        );
        return "La categoria se actualizo correctamente";
    }

    @DeleteMapping("/EliminarCategoria/{ID_Categoria}")
    @Operation(summary = "Eliminar una categoria",
              description = "Elimina de forma permanente la categoria que coincide con el ID proporcionado.")
    public String EliminarCategoria(@PathVariable String ID_Categoria){
        int filas = categoriasServicie.EliminarCategoria (ID_Categoria);

        return "La categoria se elimino correctamente";
    }
}