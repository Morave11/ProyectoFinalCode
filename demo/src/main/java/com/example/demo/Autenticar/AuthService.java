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

    public boolean validarCredenciales(String documento, String contrasenaPlano) {
        // 1. Buscar el hash guardado en la tabla Contrasenas
        String sql = "SELECT Contrasena_Hash FROM Contrasenas WHERE Documento_Empleado = ?";

        String hashGuardado;
        try {
            hashGuardado = jdbcTemplate.queryForObject(sql, String.class, documento);
        } catch (Exception e) {
            // No encontró el documento o hubo error
            return false;
        }

        if (hashGuardado == null) {
            return false;
        }

        // 2. Hashear la contraseña que envía el usuario, igual que tu trigger: SHA2(…,256)
        String hashEntrada = sha256Hex(contrasenaPlano);

        // 3. Comparar hashes
        return hashGuardado.equalsIgnoreCase(hashEntrada);
    }

    private String sha256Hex(String input) {
        try {
            MessageDigest md = MessageDigest.getInstance("SHA-256");
            byte[] bytes = md.digest(input.getBytes());
            StringBuilder sb = new StringBuilder();
            for (byte b : bytes) {
                sb.append(String.format("%02x", b));
            }
            return sb.toString();
        } catch (NoSuchAlgorithmException e) {
            throw new RuntimeException("Error calculando SHA-256", e);
        }
    }
}
