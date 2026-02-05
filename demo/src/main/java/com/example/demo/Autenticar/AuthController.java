package com.example.demo.Autenticar;

import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@Tag(name = "Login", description = "Verifica que Documento y contraseña esten bien")
@RequestMapping("/auth")
public class AuthController {

    @Autowired
    private JwtUtilidad jwtUtil;

    @Autowired
    private AuthService authService;

    @PostMapping("/login")
    @Operation(
            summary = "Autenticacion",
            description = "Endpoints encargados de validar las credenciales de los empleados y generar el token JWT de acceso al sistema"
    )
    public ResponseEntity<?> login(@RequestBody LoginRequest loginRequest) {

        String rol = authService.validarYObtenerRol(
                loginRequest.getDocumentoEmpleado(),
                loginRequest.getContrasena()
        );

        if (rol == null) {
            return ResponseEntity
                    .status(HttpStatus.UNAUTHORIZED)
                    .body("Credenciales inválidas");
        }

        String token = jwtUtil.generarToken(loginRequest.getDocumentoEmpleado());

        return ResponseEntity.ok(new LoginResponse(token, rol));
    }
}