package com.example.demo.Controller.detalleDevolucion;

import com.example.demo.DTO.DetalleDevolucion.DetalleDevolucionesDTO;
import com.example.demo.Servicie.detalleDevolucion.DetalleDService;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@Tag(name = "DetalleDevolucion", description = "Operaciones sobre la tabla detalle devolucion")
public class DetalleDController {

    @Autowired
    private DetalleDService detalleDService;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/DetalleD")
    @Operation(summary = "Obtener detalle devolucion",
            description = "Devuelve una lista con todos los detalle devolucion almacenados en la tabla detalle devolucion.")
    public List<String> obtenerDetalleD() {
        return detalleDService.obtenerDetalleD();
    }

    @PostMapping("/AgregarDetalleD")
    @Operation(summary = "Registrar un nuevo detalle devolucion",
            description = "Crea un nuevo detalle devolucion en la tabla detalle devolucion a partir de los datos enviados en el cuerpo de la petición.")
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
    @Operation(summary = "Actualizar un detalle devolucion existente",
            description = "Modifica los datos de un detalle devolucion según el ID proporcionado en la URL.")
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
    @Operation(summary = "Eliminar un detalle devolucion",
            description = "Elimina de forma permanente el detalle devolucion que coincide con el ID proporcionado.")
    public String eliminarDevolucionD(@PathVariable String ID_Devolucion,
                                      @PathVariable String ID_Venta) {
        int filas = detalleDService.eliminarDevolucionD(ID_Devolucion, ID_Venta);
        return filas > 0 ? "Detalle de devolución eliminado correctamente"
                : "Error al eliminar Detalle de devolución";
    }

}