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

        // 🔹 Validar credenciales y obtener rol
        String rol = authService.validarYObtenerRol(
                loginRequest.getDocumentoEmpleado(),
                loginRequest.getContrasena()
        );

        // ❌ Credenciales inválidas
        if (rol == null) {
            return ResponseEntity
                    .status(HttpStatus.UNAUTHORIZED)
                    .body("Credenciales inválidas");
        }

        // ✅ Generar token JWT
        String token = jwtUtil.generarToken(loginRequest.getDocumentoEmpleado());

        // ✅ Respuesta con token + rol
        LoginResponse response = new LoginResponse(token, rol);

        return ResponseEntity.ok(response);
    }
}
