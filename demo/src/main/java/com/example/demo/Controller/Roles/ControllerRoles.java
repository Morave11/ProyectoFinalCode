package com.example.demo.Controller.Roles;

import com.example.demo.DTO.Roles.RolesDTO;
import com.example.demo.Servicie.Roles.ServicieRoles;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@Tag(name = "Roles", description = "Operaciones sobre la tabla Roles")
public class ControllerRoles {

    @Autowired
    private ServicieRoles servicieRoles;


    @GetMapping("/Roles")
    @Operation(summary = "Obtener Roles",
            description = "Devuelve una lista con todos los roles almacenados en la tabla Roles.")
    public List<String> obtenerRoles() {
        return servicieRoles.obtenerRoles();
    }


    @PostMapping("/RolesR")
    @Operation(summary = "Registrar un nuevo Rol",
            description = "Crea un nuevo rol en la tabla Roles a partir de los datos enviados en el cuerpo de la petición.")
    public String agregarRol(@RequestBody RolesDTO rolesDTO) {
        servicieRoles.agregarRol(
                rolesDTO.getID_Rol(),
                rolesDTO.getNombre()
        );
        return "Rol registrado correctamente";
    }


    @PutMapping("/RolesAc/{ID_Rol}")
    @Operation(summary = "Actualizar un Rol existente",
            description = "Modifica los datos de un Rol según el ID proporcionado en la URL.")
    public String actualizarRol(@PathVariable String ID_Rol, @RequestBody RolesDTO rolesDTO) {
        int filas = servicieRoles.actualizarRol(ID_Rol, rolesDTO.getNombre());
        return filas > 0 ? "Rol actualizado correctamente" : "Error al actualizar el rol";
    }


    @DeleteMapping("/RolesEL/{ID_Rol}")
    @Operation(summary = "Eliminar un Rol",
            description = "Elimina de forma permanente el rol que coincide con el ID proporcionado.")
    public String eliminarRol(@PathVariable String ID_Rol) {
        int filas = servicieRoles.eliminarRol(ID_Rol);
        return filas > 0 ? "Rol eliminado correctamente" : "Error al eliminar el rol";
    }
}