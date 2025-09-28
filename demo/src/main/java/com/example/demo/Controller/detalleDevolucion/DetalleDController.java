package com.example.demo.Controller.detalleDevolucion;

import com.example.demo.DTO.DetalleDevolucion.DetalleDevolucionesDTO;
import com.example.demo.Servicie.detalleDevolucion.DetalleDService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class DetalleDController {

    @Autowired
    private DetalleDService detalleDService;

    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/DetalleD")
    public List<String> obtenerDetalleD() {
        return detalleDService.obtenerDetalleD();
    }

    @PostMapping("/AgregarDetalleD")
    public String agregarDetalleD(@RequestBody DetalleDevolucionesDTO detalleDDTO) {
        detalleDService.agregarDetalleD(
                detalleDDTO.getID_DetalleDev(),
                detalleDDTO.getID_Devolucion(),
                detalleDDTO.getID_Venta(),
                detalleDDTO.getCantidad_Devuelta()
        );
        return "El detalle de devolución se registró correctamente";
    }

    @PutMapping("/ActualizarDetalleD/{ID_Devolucion}/{ID_Venta}")
    public String actualizarDetalleD(@PathVariable String ID_Devolucion,
                                     @PathVariable String ID_Venta,
                                     @RequestBody DetalleDevolucionesDTO detalleDDTO) {
        int filas = detalleDService.actualizarDetalleD(
                ID_Devolucion,
                ID_Venta,
                detalleDDTO.getCantidad_Devuelta()
        );

        return filas > 0 ? "Detalle de devolución actualizado correctamente"
                : "Error al actualizar Detalle de devolución";
    }



    @DeleteMapping("/EliminarDetD/{ID_Devolucion}/{ID_Venta}")
    public String eliminarDevolucionD(@PathVariable String ID_Devolucion,
                                      @PathVariable String ID_Venta) {
        int filas = detalleDService.eliminarDevolucionD(ID_Devolucion, ID_Venta);
        return filas > 0 ? "Detalle de devolución eliminado correctamente"
                : "Error al eliminar Detalle de devolución";
    }

}