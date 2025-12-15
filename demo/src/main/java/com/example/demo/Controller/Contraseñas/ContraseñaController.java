package com.example.demo.Controller.Contraseñas;

import com.example.demo.DTO.Contraseñas.ContraseñaDTO;
import com.example.demo.DTO.Login.LoginDTO;
import com.example.demo.Servicie.Contraseñas.ContraseñaServicie;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@Tag(name = "Contraseña", description = "Operaciones sobre la tabla Contraseña")
public class ContraseñaController {
    @Autowired
    private ContraseñaServicie contraseñaServicie;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/Contrasenas")
    @Operation(summary = "Obtener Contraseñas",
            description = "Devuelve una lista con todos las contraseñas almacenados en la tabla Contraseña.")
    public List<String> ObtenerContrasenas() {
        return contraseñaServicie.ObtenerContraseñas();
    }

    @PostMapping("/RegistrarContrasena")
    @Operation(summary = "Registrar una nueva contraseña",
            description = "Crea un nueva contraseña en la tabla contraseña a partir de los datos enviados en el cuerpo de la petición.")
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
    @Operation(summary = "Actualizar un Contrasena existente",
            description = "Modifica los datos de una Contrasena según el ID proporcionado en la URL.")
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
    @Operation(summary = "Eliminar una Contraseña",
            description = "Elimina de forma permanente la Contraseña que coincide con el ID proporcionado.")
    public String EliminarContrasena(@PathVariable String ID_Contrasena) {
        int filas = contraseñaServicie.EliminarContrasena(ID_Contrasena);
        return "Contraseña eliminada correctamente";
    }

    @PostMapping("/EmpleadoLogin")
    @Operation(summary = "Login de empleado",
            description = "Valida las credenciales del empleado (documento y contraseña). "
                    + "Devuelve un mensaje indicando si el acceso es correcto o si las credenciales son inválidas."
    )
    public String loginEmpleado(@RequestBody LoginDTO loginDTO) {

        boolean valido = contraseñaServicie.validarLogin(
                loginDTO.getDocumento(),
                loginDTO.getContrasena()
        );

        if (valido) {
            return "Login correcto";
        } else {
            return "Credenciales incorrectas";
        }
    }

}
