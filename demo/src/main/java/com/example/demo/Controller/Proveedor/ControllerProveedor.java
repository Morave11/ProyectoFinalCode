package com.example.demo.Controller.Proveedor;

import com.example.demo.DTO.Proveedor.ProveedorDTO;
import com.example.demo.Servicie.Proveedor.ServicieProveedor;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class ControllerProveedor {
    @Autowired
    private ServicieProveedor servicieProveedor;
    @Autowired
    JdbcTemplate jdbcTemplate;
    @GetMapping("/Proveedor")
    public List<String> ObtenerProveedores(){ return servicieProveedor.ObtenerProveedores();}

    @PostMapping("/ProveeReg")
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
    public String EliminarProveedor(@PathVariable String ID_Proveedor) {
        int filas = servicieProveedor.EliminarProveedor (ID_Proveedor);

        return   "Proveedor eliminado correctamente" ;
    }


}
