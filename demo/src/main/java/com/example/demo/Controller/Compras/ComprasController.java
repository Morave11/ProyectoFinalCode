package com.example.demo.Controller.Compras;

import com.example.demo.DTO.Compras.ComprasDTO;
import com.example.demo.Servicie.Compras.ComprasServicie;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@Tag(name = "Compras", description = "Operaciones sobre la tabla Compras")
public class ComprasController {

    @Autowired
    private ComprasServicie comprasServicie;


    @GetMapping("/Compras")
    @Operation(summary = "Obtener Compras",
            description = "Devuelve una lista con todos las compras almacenados en la tabla Compras.")
    public List<String> obtenerCompras() {
        return comprasServicie.obtenerCompras();
    }


    @PostMapping("/ComprasR")
    @Operation(summary = "Registrar una nueva compra",
            description = "Crea un nueva compra en la tabla Compras a partir de los datos enviados en el cuerpo de la petición.")
    public String agregarCompra(@RequestBody ComprasDTO compraDTO) {
        comprasServicie.agregarCompra(
                compraDTO.getID_Entrada(),
                compraDTO.getPrecio_Compra(),
                compraDTO.getID_Producto(),
                compraDTO.getDocumento_Empleado()
        );
        return "Compra registrada correctamente";
    }


    @PutMapping("/Compras/{ID_Entrada}")
    @Operation(summary = "Actualizar un compra existente",
            description = "Modifica los datos de una compra según el ID proporcionado en la URL.")
    public String actualizarCompra(@PathVariable String ID_Entrada, @RequestBody ComprasDTO compraDTO) {
        int filas = comprasServicie.actualizarCompra(
                ID_Entrada,
                compraDTO.getPrecio_Compra(),
                compraDTO.getID_Producto(),
                compraDTO.getDocumento_Empleado()
        );
        return filas > 0 ? "Compra actualizada correctamente" : "No se encontró la compra";
    }


    @DeleteMapping("/ComprasE/{ID_Entrada}")
    @Operation(summary = "Eliminar una compra",
            description = "Elimina de forma permanente la compra que coincide con el ID proporcionado.")
    public String eliminarCompra(@PathVariable String ID_Entrada) {
        int filas = comprasServicie.eliminarCompra(ID_Entrada);
        return filas > 0 ? "Compra eliminada correctamente" : "No se encontró la compra";
    }
}