package com.example.demo.Controller.Compras;

import com.example.demo.DTO.Compras.ComprasDTO;
import com.example.demo.Servicie.Compras.ComprasServicie;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class ComprasController {

    @Autowired
    private ComprasServicie comprasServicie;

    // GET
    @GetMapping("/Compras")
    public List<String> obtenerCompras() {
        return comprasServicie.obtenerCompras();
    }

    // POST
    @PostMapping("/ComprasR")
    public String agregarCompra(@RequestBody ComprasDTO compraDTO) {
        comprasServicie.agregarCompra(
                compraDTO.getID_Entrada(),
                compraDTO.getPrecio_Compra(),
                compraDTO.getID_Producto(),
                compraDTO.getDocumento_Empleado()
        );
        return "Compra registrada correctamente";
    }

    // PUT
    @PutMapping("/Compras/{ID_Entrada}")
    public String actualizarCompra(@PathVariable String ID_Entrada, @RequestBody ComprasDTO compraDTO) {
        int filas = comprasServicie.actualizarCompra(
                ID_Entrada,
                compraDTO.getPrecio_Compra(),
                compraDTO.getID_Producto(),
                compraDTO.getDocumento_Empleado()
        );
        return filas > 0 ? "Compra actualizada correctamente" : "No se encontró la compra";
    }

    // DELETE
    @DeleteMapping("/ComprasE/{ID_Entrada}")
    public String eliminarCompra(@PathVariable String ID_Entrada) {
        int filas = comprasServicie.eliminarCompra(ID_Entrada);
        return filas > 0 ? "Compra eliminada correctamente" : "No se encontró la compra";
    }
}