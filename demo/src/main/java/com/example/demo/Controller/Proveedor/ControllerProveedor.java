package com.example.demo.Controller.Proveedor;

import com.example.demo.DTO.Proveedor.ProveedorDTO;
import com.example.demo.Servicie.Proveedor.ServicieProveedor;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@Tag(name = "Proveedor", description = "Operaciones sobre la tabla proveedor")
public class ControllerProveedor {
    @Autowired
    private ServicieProveedor servicieProveedor;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/Proveedor")
    @Operation(summary = "Obtener Proveedor",
            description = "Devuelve una lista con todas los Proveedores almacenados en la tabla proveedor.")
    public List<String> ObtenerProveedores(){ return servicieProveedor.ObtenerProveedores();}

    @PostMapping("/ProveeReg")
    @Operation(summary = "Registrar un nuevo proveedor",
            description = "Crea un nuevo proveedor en la tabla proveedor a partir de los datos enviados en el cuerpo de la petición.")
    public String agregaProveedores(@RequestBody ProveedorDTO proveedorDTO){
        servicieProveedor.agregaProveedores(
                proveedorDTO.getID_Proveedor(),
                proveedorDTO.getNombre_Proveedor(),
                proveedorDTO.getCorreo_Electronico(),
                proveedorDTO.getTelefono(),
                proveedorDTO.getID_Estado()
        );
        return "Cliente esta registrado correctamente";
    }

    @PutMapping("/ActualizaProv/{ID_Proveedor}")
    @Operation(summary = "Actualizar un proveedor existente",
            description = "Modifica los datos de un proveedor según el ID proporcionado en la URL.")
    public String ActualizaProveedores(@PathVariable("ID_Proveedor") String ID_Proveedor, @RequestBody ProveedorDTO proveedorDTO ) {
        int filas = servicieProveedor.ActualizaProveedores(
                ID_Proveedor,
                proveedorDTO.getNombre_Proveedor(),
                proveedorDTO.getCorreo_Electronico(),
                proveedorDTO.getTelefono(),
                proveedorDTO.getID_Estado()
        );
        return   "El proveedor  se actualizo correctamente" ;
    }
    @DeleteMapping("/EliminarProve/{ID_Proveedor}")
    @Operation(summary = "Eliminar un proveedor",
            description = "Elimina de forma permanente el proveedor que coincide con el ID proporcionado.")
    public String EliminarProveedor(@PathVariable String ID_Proveedor) {
        int filas = servicieProveedor.EliminarProveedor (ID_Proveedor);

        return   "Proveedor eliminado correctamente" ;
    }


}
