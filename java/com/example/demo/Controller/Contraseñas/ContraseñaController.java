package com.example.demo.Controller.Contraseñas;

import com.example.demo.DTO.Contraseñas.ContraseñaDTO;
import com.example.demo.Servicie.Contraseñas.ContraseñaServicie;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class ContraseñaController {

    @Autowired
    private ContraseñaServicie contraseñaServicie;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/Contrasenas")
    public List<String> ObtenerContrasenas() {
        return contraseñaServicie.ObtenerContraseñas();
    }

    @PostMapping("/RegistrarContrasena")
    public String AgregarContrasena(@RequestBody ContraseñaDTO contrasenaDTO) {
        contraseñaServicie.AgregarContrasena(
                contrasenaDTO.getID_Contrasena(),
                contrasenaDTO.getDocumento_Empleado(),
                contrasenaDTO.getContrasena_Hash(),
                contrasenaDTO.getFecha_Creacion()
        );
        return "Contraseña registrada correctamente";
    }

    @PutMapping("/ActualizarContrasena/{ID_Contrasena}")
    public String ActualizarContrasena(@PathVariable("ID_Contrasena") String ID_Contrasena, @RequestBody ContraseñaDTO contrasenaDTO) {
        int filas = contraseñaServicie.ActualizarContrasena(
                ID_Contrasena,
                contrasenaDTO.getDocumento_Empleado(),
                contrasenaDTO.getContrasena_Hash(),
                contrasenaDTO.getFecha_Creacion()
        );
            return "Contraseña actualizada correctamente";
    }

    @DeleteMapping("/EliminarContrasena/{ID_Contrasena}")
    public String EliminarContrasena(@PathVariable String ID_Contrasena) {
        int filas = contraseñaServicie.EliminarContrasena(ID_Contrasena);
            return "Contraseña eliminada correctamente";
    }
}

