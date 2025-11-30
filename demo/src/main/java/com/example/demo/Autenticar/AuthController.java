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
