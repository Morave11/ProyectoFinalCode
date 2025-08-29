package com.example.demo.Controller.detalleDevolucion;

import com.example.demo.DTO.DetalleDevolucion.DetalleDevolucionesDTO;
import com.example.demo.DTO.Devoluciones.DevolucionesDTO;
import com.example.demo.Servicie.Devoluciones.DevolucionService;
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
    public List<String> obtenerDetalleD() { return detalleDService.obtenerDetalleD();}


    @PostMapping("/AgregarDetalleD")
    public String agregarDetalleD (@RequestBody DetalleDevolucionesDTO detalleDDTO){
        detalleDService.agregarDetalleD(
                detalleDDTO.getID_Devolucion(),
                detalleDDTO.getCantidad_Devuelta(),
                detalleDDTO.getID_Venta()

        );
        return "La Devolucion se registro correctamente";
    }


    @PutMapping("/ActualizarDetalleD/{ID_Devolucion}")
    public String actualizarDetalleD(@PathVariable("ID_Devolucion") String ID_Devolucion, @RequestBody DetalleDevolucionesDTO detalleDDTO) {
        int filas = detalleDService.actualizarDetalleD(
                ID_Devolucion,
                detalleDDTO.getCantidad_Devuelta(),
                detalleDDTO.getID_Venta()
        );
        return "La Devolucion se ha actualizado correctamente";
    }

    @DeleteMapping("/EliminarDetD/{ID_Devolucion}")
    public String eliminarDevolucionD(@PathVariable String ID_Devolucion) {
        int filas = detalleDService.eliminarDevolucionD (ID_Devolucion);

        return   "Producto eliminado correctamente" ;
    }
}