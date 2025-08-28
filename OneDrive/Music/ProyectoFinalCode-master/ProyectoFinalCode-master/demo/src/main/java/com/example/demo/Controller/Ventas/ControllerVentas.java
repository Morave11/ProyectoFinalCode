package com.example.demo.Controller.Ventas;

import com.example.demo.DTO.Ventas.VentasDTO;
import com.example.demo.Servicie.Ventas.ServiceVentas;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class ControllerVentas {

    @Autowired
    private ServiceVentas serviceVentas;

    @GetMapping("/Ventas")
    public List<String> obtenerVentas() {
        return serviceVentas.obtenerVentas();
    }

    @PostMapping("/VentaRegistro")
    public String agregarVenta(@RequestBody VentasDTO ventaDTO) {
        serviceVentas.agregarVenta(
                ventaDTO.getID_Venta(),
                ventaDTO.getDocumento_Cliente(),
                ventaDTO.getDocumento_Empleado()
        );
        return "Venta registrada correctamente";
    }

    @PutMapping("/VentaActualizar/{ID_Venta}")
    public String actualizarVenta(@PathVariable String ID_Venta, @RequestBody VentasDTO ventaDTO) {
        int filas = serviceVentas.actualizarVenta(
                ID_Venta,
                ventaDTO.getDocumento_Cliente(),
                ventaDTO.getDocumento_Empleado()
        );
        return filas > 0 ? "Venta actualizada correctamente" : "Error al actualizar venta";
    }

    @DeleteMapping("/VentaEliminar/{ID_Venta}")
    public String eliminarVenta(@PathVariable String ID_Venta) {
        int filas = serviceVentas.eliminarVenta(ID_Venta);
        return filas > 0 ? "Venta eliminada correctamente" : "Error al eliminar venta";
    }
}