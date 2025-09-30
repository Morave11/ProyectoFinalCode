package com.example.demo.Autenticar;

import com.example.demo.DTO.Contraseñas.ContraseñaDTO;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/auth")
public class AuthController {

    @Autowired
    private JwtUtilidad jwtUtil;

    @PostMapping("/login")
    public String login(@RequestBody ContraseñaDTO contraseña) {

        if ("admin".equals(contraseña.getDocumento_Empleado()) && "password".equals(contraseña.getID_Contrasena())) {
            return jwtUtil.generarToken(contraseña.getDocumento_Empleado());
        } else {
            throw new RuntimeException("Credenciales invalidas");
 }
}
}