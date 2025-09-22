package com.example.demo.Controller.Producto;


import com.example.demo.DTO.Producto.ProductoDTO;
import com.example.demo.Servicie.Producto.ProductoServicie;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class ProductoController {

    @Autowired
    private ProductoServicie productoServicie;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping ("/Productos")
    public List<String> obtenerProductos(){ return productoServicie.ObtenerProductos();}

    @PostMapping("/RegistroP")
    public String AgregarProductos(@RequestBody ProductoDTO productoDTO){
        productoServicie.AgregarProductos(
                productoDTO.getID_Producto(),
                productoDTO.getNombre_Producto(),
                productoDTO.getDescripcion(),
                productoDTO.getPrecio_Venta(),
                productoDTO.getStock_Minimo(),
                productoDTO.getID_Categoria(),
                productoDTO.getID_Estado(),
                productoDTO.getID_Gama()
        );
        return "Producto esta registrado correctamente";
    }


    @PutMapping("/ActualizaProd/{ID_Producto}")
    public String actualizarProductos(@PathVariable("ID_Producto") String ID_Producto, @RequestBody ProductoDTO producto ) {
        int filas = productoServicie.actualizarProductos(
                ID_Producto,
                producto.getNombre_Producto(),
                producto.getDescripcion(),
                producto.getPrecio_Venta(),
                producto.getStock_Minimo(),
                producto.getID_Categoria(),
                producto.getID_Estado(),
                producto.getID_Gama()
        );
        return filas > 0 ? "Producto actualizado correctamente" : "Producto no encontrado o sin cambios";
    }

    @DeleteMapping("/EliminarPro/{ID_Producto}")
    public String EliminarProductos(@PathVariable String ID_Producto) {
        int filas = productoServicie.EliminarProductos (ID_Producto);

        return filas > 0 ? "Producto eliminado correctamente" : "Producto no encontrado";
    }

}