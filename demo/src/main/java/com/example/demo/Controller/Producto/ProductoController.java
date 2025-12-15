package com.example.demo.Controller.Producto;

import com.example.demo.DTO.Producto.ProductoDTO;
import com.example.demo.Servicie.Producto.ProductoServicie;
import com.fasterxml.jackson.databind.ObjectMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;

import java.util.List;

@RestController
@Tag(name = "Productos", description = "Operaciones sobre la tabla productos")
public class ProductoController {

    @Autowired
    private ProductoServicie productoServicie;
    @Autowired
    JdbcTemplate jdbcTemplate;
    @Autowired
    private ObjectMapper objectMapper;

    @GetMapping("/Productos")
    @Operation(
            summary = "Obtener Productos",
            description = "Devuelve una lista con todos los productos almacenados en la tabla Productos."
    )
    public List<String> obtenerProductos() {
        return productoServicie.ObtenerProductos();
    }

    @PostMapping("/RegistroP")
    @Operation(
            summary = "Registrar un nuevo producto",
            description = "Crea un nuevo producto en la tabla productos a partir de los datos enviados en el cuerpo de la petición."
    )
    public String AgregarProductos(@RequestBody ProductoDTO productoDTO) {

        productoServicie.AgregarProductos(
                productoDTO.getID_Producto(),
                productoDTO.getNombre_Producto(),
                productoDTO.getDescripcion(),
                productoDTO.getPrecio_Venta(),
                productoDTO.getStock_Minimo(),
                productoDTO.getID_Categoria(),
                productoDTO.getID_Estado(),
                productoDTO.getID_Gama(),
                productoDTO.getFotos() //
        );

        return "Producto esta registrado correctamente";
    }

    @PutMapping("/ActualizaProd/{ID_Producto}")
    @Operation(
            summary = "Actualizar un producto existente",
            description = "Modifica los datos de un producto según el ID proporcionado en la URL."
    )
    public String actualizarProductos(
            @PathVariable("ID_Producto") String ID_Producto,
            @RequestBody ProductoDTO producto
    ) {

        int filas = productoServicie.actualizarProductos(
                ID_Producto,
                producto.getNombre_Producto(),
                producto.getDescripcion(),
                producto.getPrecio_Venta(),
                producto.getStock_Minimo(),
                producto.getID_Categoria(),
                producto.getID_Estado(),
                producto.getID_Gama(),
                producto.getFotos()
        );

        return filas > 0 ? "Producto actualizado correctamente" : "Producto no encontrado o sin cambios";
    }

    @DeleteMapping("/EliminarPro/{ID_Producto}")
    @Operation(
            summary = "Eliminar un producto",
            description = "Elimina de forma permanente el producto que coincide con el ID proporcionado."
    )
    public String EliminarProductos(@PathVariable String ID_Producto) {

        int filas = productoServicie.EliminarProductos(ID_Producto);

        return filas > 0 ? "Producto eliminado correctamente" : "Producto no encontrado";
    }

    @PostMapping(
            value = "/RegistroPMultipart",
            consumes = MediaType.MULTIPART_FORM_DATA_VALUE
    )
    @Operation(
            summary = "Registrar producto (multipart)",
            description = "Registra un producto enviando 'data' (JSON) y 'file' (imagen)."
    )
    public String AgregarProductosMultipart(
            @RequestPart("data") String dataJson,
            @RequestPart(value = "file", required = false) MultipartFile file
    ) throws Exception {

        ProductoDTO data = objectMapper.readValue(dataJson, ProductoDTO.class);

        productoServicie.AgregarProductosMultipart(
                data.getID_Producto(),
                data.getNombre_Producto(),
                data.getDescripcion(),
                data.getPrecio_Venta(),
                data.getStock_Minimo(),
                data.getID_Categoria(),
                data.getID_Estado(),
                data.getID_Gama(),
                file
        );

        return "Producto registrado correctamente (multipart)";
    }

    @PutMapping(
            value = "/ActualizaProdMultipart/{ID_Producto}",
            consumes = MediaType.MULTIPART_FORM_DATA_VALUE
    )
    @Operation(
            summary = "Actualizar producto (multipart)",
            description = "Actualiza un producto enviando 'data' (JSON) y 'file' (imagen)."
    )
    public String actualizarProductosMultipart(
            @PathVariable("ID_Producto") String ID_Producto,
            @RequestPart("data") String dataJson,
            @RequestPart(value = "file", required = false) MultipartFile file
    ) throws Exception {

        ProductoDTO data = objectMapper.readValue(dataJson, ProductoDTO.class);

        int filas = productoServicie.actualizarProductosMultipart(
                ID_Producto,
                data.getNombre_Producto(),
                data.getDescripcion(),
                data.getPrecio_Venta(),
                data.getStock_Minimo(),
                data.getID_Categoria(),
                data.getID_Estado(),
                data.getID_Gama(),
                file
        );

        return filas > 0
                ? "Producto actualizado correctamente (multipart)"
                : "Producto no encontrado o sin cambios";
    }
}
