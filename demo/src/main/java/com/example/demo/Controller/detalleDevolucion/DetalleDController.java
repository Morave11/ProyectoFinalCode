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
                detalleDDTO.getID_Devolucion(),
                detalleDDTO.getCantidad_Devuelta(),
                detalleDDTO.getID_Venta()
        );
        return "El detalle de devolución se registró correctamente";
    }


    @PutMapping("/ActualizarDetalleD/{ID_Devolucion}/{ID_Venta}")
    public String actualizarDetalleD(@PathVariable("ID_Devolucion") String ID_Devolucion,
                                     @PathVariable("ID_Venta") String ID_Venta,
                                     @RequestBody DetalleDevolucionesDTO detalleDDTO) {
        int filas = detalleDService.actualizarDetalleD(
                ID_Devolucion,
                ID_Venta,
                detalleDDTO.getCantidad_Devuelta()
        );
        return "El detalle de devolución se ha actualizado correctamente";
    }


    @DeleteMapping("/EliminarDetD/{ID_Devolucion}/{ID_Venta}")
    public String eliminarDevolucionD(@PathVariable String ID_Devolucion,
                                      @PathVariable String ID_Venta) {
        int filas = detalleDService.eliminarDevolucionD(ID_Devolucion, ID_Venta);
        return "Detalle de devolución eliminado correctamente";
    }
}