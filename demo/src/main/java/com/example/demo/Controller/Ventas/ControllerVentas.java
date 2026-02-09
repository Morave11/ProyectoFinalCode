package com.example.demo.Controller.Ventas;

import com.example.demo.DTO.Ventas.VentasDTO;
import com.example.demo.Servicie.Ventas.ServiceVentas;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@Tag(name = "Ventas", description = "Operaciones sobre la tabla ventas")
public class ControllerVentas {

    @Autowired
    private ServiceVentas serviceVentas;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/Ventas")
    @Operation(summary = "Obtener Ventas",
            description = "Devuelve una lista con todas las Ventas almacenados en la tabla ventas.")
    public List<String> obtenerVentas() {
        return serviceVentas.obtenerVentas();
    }

    @PostMapping("/VentaRegistro")
    @Operation(summary = "Registrar una nueva venta",
            description = "Crea una nueva venta en la tabla venta a partir de los datos enviados en el cuerpo de la petición.")
    public String agregarVenta(@RequestBody VentasDTO ventaDTO) {
        serviceVentas.agregarVenta(
                ventaDTO.getDocumento_Cliente(),
                ventaDTO.getDocumento_Empleado()
        );
        return "Venta registrada correctamente";
    }

    @PutMapping("/VentaActualizar/{ID_Venta}")
    @Operation(summary = "Actualizar una venta existente",
            description = "Modifica los datos de una venta según el ID proporcionado en la URL.")
    public String actualizarVenta(@PathVariable String ID_Venta, @RequestBody VentasDTO ventaDTO) {
        int filas = serviceVentas.actualizarVenta(
                ID_Venta,
                ventaDTO.getDocumento_Cliente(),
                ventaDTO.getDocumento_Empleado()
        );
        return filas > 0 ? "Venta actualizada correctamente" : "Error al actualizar venta";
    }

    @DeleteMapping("/VentaEliminar/{ID_Venta}")
    @Operation(summary = "Eliminar una venta",
            description = "Elimina de forma permanente la venta que coincide con el ID proporcionado.")
    public String eliminarVenta(@PathVariable String ID_Venta) {
        int filas = serviceVentas.eliminarVenta(ID_Venta);
        return filas > 0 ? "Venta eliminada correctamente" : "Error al eliminar venta";
    }
}