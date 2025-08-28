package com.example.demo.Controller.Roles;

import com.example.demo.DTO.Roles.RolesDTO;
import com.example.demo.Servicie.Roles.ServicieRoles;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class ControllerRoles {

    @Autowired
    private ServicieRoles servicieRoles;

    // Obtener todos los roles
    @GetMapping("/Roles")
    public List<String> obtenerRoles() {
        return servicieRoles.obtenerRoles();
    }

    // Registrar un nuevo rol
    @PostMapping("/Roles/Registro")
    public String agregarRol(@RequestBody RolesDTO rolesDTO) {
        servicieRoles.agregarRol(
                rolesDTO.getID_Rol(),
                rolesDTO.getNombre()
        );
        return "Rol registrado correctamente";
    }

    // Actualizar rol
    @PutMapping("/Roles/Actualizar/{ID_Rol}")
    public String actualizarRol(@PathVariable String ID_Rol, @RequestBody RolesDTO rolesDTO) {
        int filas = servicieRoles.actualizarRol(ID_Rol, rolesDTO.getNombre());
        return filas > 0 ? "Rol actualizado correctamente" : "Error al actualizar el rol";
    }

    // Eliminar rol
    @DeleteMapping("/Roles/Eliminar/{ID_Rol}")
    public String eliminarRol(@PathVariable String ID_Rol) {
        int filas = servicieRoles.eliminarRol(ID_Rol);
        return filas > 0 ? "Rol eliminado correctamente" : "Error al eliminar el rol";
    }
}