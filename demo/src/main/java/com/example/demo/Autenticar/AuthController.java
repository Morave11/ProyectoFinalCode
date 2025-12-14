package com.example.demo.Autenticar;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/auth")
public class AuthController {

    @Autowired
    private JwtUtilidad jwtUtil;

    @Autowired
    private AuthService authService;

    @PostMapping("/login")
    public ResponseEntity<?> login(@RequestBody LoginRequest loginRequest) {

        // ✅ Valida credenciales y devuelve rol si OK
        String rol = authService.validarYObtenerRol(
                loginRequest.getDocumentoEmpleado(),
                loginRequest.getContrasena()
        );

        if (rol == null) {
            return ResponseEntity
                    .status(HttpStatus.UNAUTHORIZED)
                    .body("Credenciales inválidas");
        }

        // ✅ Crear token
        String token = jwtUtil.generarToken(loginRequest.getDocumentoEmpleado());

        // ✅ Responder JSON: { token: "...", rol: "ROL001" }
        return ResponseEntity.ok(new LoginResponse(token, rol));
    }
}