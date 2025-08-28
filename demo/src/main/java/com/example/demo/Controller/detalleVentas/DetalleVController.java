package com.example.demo.Controller.detalleVentas;
import com.example.demo.DTO.DetalleVentas.DetalleVentasDTO;
import com.example.demo.Servicie.detalleVentas.DetalleVService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

public class DetalleVController {
    @Autowired
    private DetalleVService detalleVService;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/DetalleV")
    public List<String> obtenerDetalleV() { return detalleVService.obtenerDetalleV();}


    @PostMapping("/AgregarDetalleV")
    public String agregarDetalleV (@RequestBody DetalleVentasDTO detalleVDTO){
        detalleVService.agregarDetalleV(
                detalleVDTO.getID_Venta(),
                detalleVDTO.getID_Producto(),
                detalleVDTO.getCantidad(),
                detalleVDTO.getFecha_Salida()
        );
        return "El Detalle Venta se registro correctamente";
    }


    @PutMapping("/ActualizarDetalleV/{ID_Venta}/{ID_Producto}")
    public String actualizarDetalleV(@PathVariable("ID_Venta") String ID_Venta, @PathVariable("ID_Producto") String ID_Producto,
                                     @RequestBody DetalleVentasDTO detalleVDTO) {

        int filas = detalleVService.actualizarDetalleV(
                ID_Venta, ID_Producto,
                detalleVDTO.getCantidad()

        );

        return "El Detalle de Venta se ha actualizado correctamente";
    }

    @DeleteMapping("/EliminarDetV/{ID_Venta}/{ID_Producto}")
    public String eliminarDetalleV(@PathVariable String ID_Venta, @PathVariable String ID_Producto) {
        int filas = detalleVService.eliminarDevolucionV (ID_Venta, ID_Producto);

        return   "Detalle Ventas eliminada correctamente" ;
    }
}