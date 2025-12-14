package com.example.demo.Controller.detalleVentas;

import com.example.demo.DTO.DetalleVentas.DetalleVentasDTO;
import com.example.demo.Servicie.detalleVentas.DetalleVServicie;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@Tag(name = "DetalleVenta", description = "Operaciones sobre la tabla detalle venta")
public class DetalleVController {

    @Autowired
    private DetalleVServicie detalleVService;

    @GetMapping("/DetalleVentas")
    @Operation(summary = "Obtener detalle venta",
            description = "Devuelve una lista con todos los detalle venta almacenados en la tabla detalle venta.")
    public List<String> obtenerDetalleVentas() {
        return detalleVService.obtenerDetalleVentas();
    }

    @PostMapping("/DetalleVentasRegistro")
    @Operation(summary = "Registrar un nuevo detalle venta",
            description = "Crea un nuevo detalle venta en la tabla detalle venta a partir de los datos enviados en el cuerpo de la petición.")
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
    @Operation(summary = "Actualizar un detalle venta existente",
            description = "Modifica los datos de un detalle venta según el ID proporcionado en la URL.")
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
    @Operation(summary = "Eliminar un detalle venta",
            description = "Elimina de forma permanente el detalle venta que coincide con el ID proporcionado.")
    public String eliminarDetalleVenta(@PathVariable String ID_Producto,
                                       @PathVariable String ID_Venta) {
        int filas = detalleVService.eliminarDetalleVenta(ID_Producto, ID_Venta);
        return filas > 0 ? "Detalle de venta eliminado correctamente" : "No se encontró el detalle de venta";
    }
}