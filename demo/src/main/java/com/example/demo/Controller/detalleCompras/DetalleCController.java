package com.example.demo.Controller.detalleCompras;

import com.example.demo.DTO.DetallesCompras.DetalleComprasDTO;
import com.example.demo.Servicie.detalleCompras.DetalleCService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

public class DetalleCController {
    @Autowired
    private DetalleCService detalleCService;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/DetalleC")
    public List<String> obtenerDetalleC() { return detalleCService.obtenerDetalleC();}


    @PostMapping("/AgregarDetalleC")
    public String agregarDetalleC (@RequestBody DetalleComprasDTO detalleCDTO){
        detalleCService.agregarDetalleC(
                detalleCDTO.getID_Entrada(),
                detalleCDTO.getID_Proveedor(),
                detalleCDTO.getCantidad(),
                detalleCDTO.getFecha_Entrada()
        );
        return "El Detalle Compra se registro correctamente";
    }


    @PutMapping("/ActualizarDetalleC/{ID_Entrada}/{ID_Proveedor}")
    public String actualizarDetalleC(@PathVariable("ID_Entrada") String ID_Entrada, @PathVariable("ID_Proveedor") String ID_Proveedor,
            @RequestBody DetalleComprasDTO detalleCDTO) {

        int filas = detalleCService.actualizarDetalleC(
                ID_Entrada,
                ID_Proveedor,
                detalleCDTO.getCantidad(),
                detalleCDTO.getFecha_Entrada()
        );

        return "El Detalle de Compra se ha actualizado correctamente";
    }

    @DeleteMapping("/EliminarDetC/{ID_Entrada}/{ID_Proveedor}")
    public String eliminarDetalleC(@PathVariable String ID_Entrada, @PathVariable String ID_Proveedor) {
        int filas = detalleCService.eliminarDevolucionC (ID_Entrada, ID_Proveedor);

        return   "Detalle Compra eliminada correctamente" ;
    }
}
