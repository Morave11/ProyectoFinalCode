package com.example.demo.Autenticar;

import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/auth")
@Tag(name = "Autenticación", description = "Obtener el Token JWT")
public class AuthController {

    @Autowired
    private JwtUtilidad jwtUtil;

    @Autowired
    private AuthService authService;

    @PostMapping("/login")
    @Operation(summary = "Login",
            description = "Devuelve un token JWT si las credenciales son válidas")
    public ResponseEntity<String> login(@RequestBody LoginRequest loginRequest) {

        boolean valido = authService.validarCredenciales(
                loginRequest.getDocumentoEmpleado(),
                loginRequest.getContrasena()
        );

        if (!valido) {
            return ResponseEntity
                    .status(HttpStatus.UNAUTHORIZED)
                    .body("Credenciales inválidas");
        }

        String token = jwtUtil.generarToken(loginRequest.getDocumentoEmpleado());
        return ResponseEntity.ok(token);
    }
}
