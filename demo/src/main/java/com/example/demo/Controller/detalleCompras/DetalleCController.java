package com.example.demo.Controller.detalleCompras;

import com.example.demo.DTO.DetallesCompras.DetalleComprasDTO;
import com.example.demo.Servicie.detalleCompras.DetalleCService;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;
@RestController
@Tag(name = "DetalleCompras", description = "Operaciones sobre la tabla detalle compras")
public class DetalleCController {

    @Autowired
    private DetalleCService detalleCService;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/DetalleC")
    @Operation(summary = "Obtener Detalle Compras",
            description = "Devuelve una lista con todos los detalle compras almacenados en la tabla detalle compras.")
    public List<String> obtenerDetalleC() { return detalleCService.obtenerDetalleC();}

    @PostMapping("/AgregarDetalleC")
    @Operation(summary = "Registrar un nuevo detalle compra",
            description = "Crea un nuevo detalle compra en la tabla detalle compra a partir de los datos enviados en el cuerpo de la petición.")
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
    @Operation(summary = "Actualizar un detalle compra existente",
            description = "Modifica los datos de un detalle compra según el ID proporcionado en la URL.")
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
    @Operation(summary = "Eliminar un detalle compra",
            description = "Elimina de forma permanente el detalle compra que coincide con el ID proporcionado.")
    public String eliminarDetalleC(@PathVariable String ID_Entrada, @PathVariable String ID_Proveedor) {
        int filas = detalleCService.eliminarDevolucionC (ID_Entrada, ID_Proveedor);

        return   "Detalle Compra eliminada correctamente" ;
    }
}
