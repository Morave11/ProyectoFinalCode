package com.example.demo.Autenticar;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

@Service
public class AuthService {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    // ✅ TU MÉTODO ORIGINAL (NO SE TOCA)
    public boolean validarCredenciales(String documento, String contrasenaPlano) {
        String sql = "SELECT Contrasena_Hash FROM Contrasenas WHERE Documento_Empleado = ?";

        String hashGuardado;
        try {
            hashGuardado = jdbcTemplate.queryForObject(sql, String.class, documento);
        } catch (Exception e) {
            return false;
        }

        if (hashGuardado == null) return false;

        String hashEntrada = sha256Hex(contrasenaPlano);

        return hashGuardado.equalsIgnoreCase(hashEntrada);
    }

    // ✅ NUEVO: devuelve el rol si es válido, o null si no
    public String validarYObtenerRol(String documento, String contrasenaPlano) {
        String sql = """
            SELECT C.Contrasena_Hash, E.ID_Rol
            FROM Contrasenas C
            INNER JOIN Empleados E ON E.Documento_Empleado = C.Documento_Empleado
            WHERE C.Documento_Empleado = ?
        """;

        try {
            return jdbcTemplate.queryForObject(sql, (rs, rowNum) -> {
                String hashGuardado = rs.getString("Contrasena_Hash");
                String rol = rs.getString("ID_Rol");

                if (hashGuardado == null || rol == null) return null;

                String hashEntrada = sha256Hex(contrasenaPlano);

                return hashGuardado.equalsIgnoreCase(hashEntrada) ? rol : null;
            }, documento);
        } catch (Exception e) {
            return null;
        }
    }

    private String sha256Hex(String input) {
        try {
            MessageDigest md = MessageDigest.getInstance("SHA-256");
            byte[] bytes = md.digest(input.getBytes());
            StringBuilder sb = new StringBuilder();
            for (byte b : bytes) sb.append(String.format("%02x", b));
            return sb.toString();
        } catch (NoSuchAlgorithmException e) {
            throw new RuntimeException("Error calculando SHA-256", e);
        }
    }
}