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

    @GetMapping("/Compras")
    public List<String> ObtenerCompras() {
        return comprasServicie.ObtenerCompras();
    }

    @PostMapping("/RegistrarCompra")
    public String AgregarCompra(@RequestBody ComprasDTO comprasDTO) {
        comprasServicie.AgregarCompra(
                comprasDTO.getID_Entrada(),
                comprasDTO.getDocumento_EMpleado(),
                comprasDTO.getID_Producto(),
                comprasDTO.getDocumento_EMpleado()
        );
        return "Compra registrada correctamente";
    }

    @PutMapping("/ActualizarCompra/{ID_Entrada}")
    public String ActualizarCompra(@PathVariable("ID_Entrada") String ID_Entrada, @RequestBody ComprasDTO comprasDTO) {
        int filas = comprasServicie.ActualizarCompra(
                ID_Entrada,
                comprasDTO.getDocumento_EMpleado(),
                comprasDTO.getID_Producto(),
                comprasDTO.getDocumento_EMpleado()
        );
            return "Compra actualizada correctamente";

    }

    @DeleteMapping("/EliminarCompra/{ID_Entrada}")
    public String EliminarCompra(@PathVariable String ID_Entrada) {
        int filas = comprasServicie.EliminarCompra(ID_Entrada);

            return "Compra eliminada correctamente";
    }
}

