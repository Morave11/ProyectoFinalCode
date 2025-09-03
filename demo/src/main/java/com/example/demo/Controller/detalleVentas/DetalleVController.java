package com.example.demo.Controller.detalleVentas;

import com.example.demo.DTO.DetalleVentas.DetalleVentasDTO;
import com.example.demo.Servicie.detalleVentas.DetalleVServicie;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class DetalleVController {

    @Autowired
    private DetalleVServicie detalleVService;

    @GetMapping("/DetalleVentas")
    public List<String> obtenerDetalleVentas() {
        return detalleVService.obtenerDetalleVentas();
    }

    @PostMapping("/DetalleVentasRegistro")
    public String agregarDetalleVenta(@RequestBody DetalleVentasDTO detalleDTO) {
        detalleVService.agregarDetalleVenta(
                detalleDTO.getCantidad(),
                detalleDTO.getFecha_Salida(),
                detalleDTO.getID_Producto(),
                detalleDTO.getID_Venta()
        );
        return "Detalle de venta registrado correctamente";
    }

    @PutMapping("/DetalleVentasActualizar/{ID_Producto}/{ID_Venta}")
    public String actualizarDetalleVenta(@PathVariable String ID_Producto,
                                         @PathVariable String ID_Venta,
                                         @RequestBody DetalleVentasDTO detalleDTO) {
        int filas = detalleVService.actualizarDetalleVenta(
                ID_Producto,
                ID_Venta,
                detalleDTO.getCantidad(),
                detalleDTO.getFecha_Salida()
        );
        return filas > 0 ? "Detalle de venta actualizado correctamente" : "No se encontró el detalle de venta";
    }

    @DeleteMapping("/DetalleVentasEliminar/{ID_Producto}/{ID_Venta}")
    public String eliminarDetalleVenta(@PathVariable String ID_Producto,
                                       @PathVariable String ID_Venta) {
        int filas = detalleVService.eliminarDetalleVenta(ID_Producto, ID_Venta);
        return filas > 0 ? "Detalle de venta eliminado correctamente" : "No se encontró el detalle de venta";
    }
}