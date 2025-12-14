package com.example.demo.Servicie.Empleados;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.util.StringUtils;
import org.springframework.web.multipart.MultipartFile;
import org.springframework.web.servlet.support.ServletUriComponentsBuilder;

import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.Base64;
import java.util.List;

@Service
public class ServiceEmpleados {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    // Carpeta uploads
    private final Path uploadsDir = Paths.get("uploads");

    // ====================== OBTENER ======================
    public List<String> obtenerEmpleados() {
        String sql = "SELECT Documento_Empleado,Tipo_Documento, Nombre_Usuario, Apellido_Usuario,Edad, Correo_Electronico,Telefono,Genero,ID_Estado,ID_Rol,Fotos FROM Empleados";
        return jdbcTemplate.query(sql, (rs, rowNum) ->
                rs.getString("Documento_Empleado") +
                        "________" + rs.getString("Tipo_Documento") +
                        "________" + rs.getString("Nombre_Usuario") +
                        "________" + rs.getString("Apellido_Usuario") +
                        "________" + rs.getString("Edad") +
                        "________" + rs.getString("Correo_Electronico") +
                        "________" + rs.getString("Telefono") +
                        "________" + rs.getString("Genero") +
                        "________" + rs.getString("ID_Estado") +
                        "________" + rs.getString("ID_Rol") +
                        "________" + (rs.getString("Fotos") == null ? "" : rs.getString("Fotos"))
        );
    }

    // ====================== INSERTAR (JSON / BASE64) ======================
    @Transactional
    public void agregarEmpleado(String Documento_Empleado, String Tipo_Documento, String Nombre_Usuario,
                                String Apellido_Usuario, String Edad, String Correo_Electronico,
                                String Telefono, String Genero, String ID_Estado, String ID_Rol,
                                String Fotos, String Contrasena) {

        Fotos = guardarBase64SiViene(Fotos, Documento_Empleado);

        // 1) Insertar empleado
        String sqlEmp = "INSERT INTO Empleados (Documento_Empleado, Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad, Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, Fotos) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        jdbcTemplate.update(sqlEmp, Documento_Empleado, Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, Fotos);

        // 2) Insertar contraseña (texto plano -> trigger SHA2(256) la hashea)
        if (Contrasena != null && !Contrasena.isBlank()) {
            String sqlPass = "INSERT INTO Contrasenas (Documento_Empleado, Contrasena_Hash) VALUES (?, ?)";
            jdbcTemplate.update(sqlPass, Documento_Empleado, Contrasena);
        }
    }

    // ====================== ACTUALIZAR (JSON / BASE64) ======================
    @Transactional
    public int actualizarEmpleado(String Documento_Empleado, String Tipo_Documento, String Nombre_Usuario,
                                  String Apellido_Usuario, String Edad, String Correo_Electronico,
                                  String Telefono, String Genero, String ID_Estado, String ID_Rol,
                                  String Fotos, String Contrasena) {

        int filas;

        // 1) Si NO viene foto nueva → no tocar Fotos
        if (Fotos == null || Fotos.isBlank()) {

            String sql = "UPDATE Empleados SET Tipo_Documento=?, Nombre_Usuario=?, Apellido_Usuario=?, Edad=?, " +
                    "Correo_Electronico=?, Telefono=?, Genero=?, ID_Estado=?, ID_Rol=? WHERE Documento_Empleado=?";

            filas = jdbcTemplate.update(sql,
                    Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                    Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol,
                    Documento_Empleado
            );

        } else {
            // 2) Si viene Base64 → guardar archivo y actualizar columna
            Fotos = guardarBase64SiViene(Fotos, Documento_Empleado);

            String sql = "UPDATE Empleados SET Tipo_Documento=?, Nombre_Usuario=?, Apellido_Usuario=?, Edad=?, " +
                    "Correo_Electronico=?, Telefono=?, Genero=?, ID_Estado=?, ID_Rol=?, Fotos=? WHERE Documento_Empleado=?";

            filas = jdbcTemplate.update(sql,
                    Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                    Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, Fotos,
                    Documento_Empleado
            );
        }

        // 3) Si viene contraseña -> upsert en Contrasenas
        if (Contrasena != null && !Contrasena.isBlank()) {
            upsertContrasena(Documento_Empleado, Contrasena);
        }

        return filas;
    }

    // ======================================================================
    // ======================= MULTIPART ====================================
    // ======================================================================

    // ====================== INSERTAR (MULTIPART) ======================
    @Transactional
    public void agregarEmpleadoMultipart(String Documento_Empleado, String Tipo_Documento, String Nombre_Usuario,
                                         String Apellido_Usuario, String Edad, String Correo_Electronico,
                                         String Telefono, String Genero, String ID_Estado, String ID_Rol,
                                         MultipartFile file, String Contrasena) {

        String fotosUrl = "";

        if (file != null && !file.isEmpty()) {
            fotosUrl = guardarArchivoYDevolverUrl(file, Documento_Empleado);
        }

        // 1) Insertar empleado
        String sqlEmp = "INSERT INTO Empleados (Documento_Empleado, Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad, Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, Fotos) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        jdbcTemplate.update(sqlEmp, Documento_Empleado, Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, fotosUrl);

        // 2) Insertar contraseña
        if (Contrasena != null && !Contrasena.isBlank()) {
            String sqlPass = "INSERT INTO Contrasenas (Documento_Empleado, Contrasena_Hash) VALUES (?, ?)";
            jdbcTemplate.update(sqlPass, Documento_Empleado, Contrasena);
        }
    }

    // ====================== ACTUALIZAR (MULTIPART) ======================
    @Transactional
    public int actualizarEmpleadoMultipart(String Documento_Empleado, String Tipo_Documento, String Nombre_Usuario,
                                           String Apellido_Usuario, String Edad, String Correo_Electronico,
                                           String Telefono, String Genero, String ID_Estado, String ID_Rol,
                                           MultipartFile file, String Contrasena) {

        int filas;

        // Si viene foto nueva: borrar anterior + guardar nueva + actualizar Fotos
        if (file != null && !file.isEmpty()) {

            String fotoActual = obtenerFotoActual(Documento_Empleado);
            borrarArchivoPorValorFotos(fotoActual);

            String nuevaUrl = guardarArchivoYDevolverUrl(file, Documento_Empleado);

            String sql = "UPDATE Empleados SET Tipo_Documento=?, Nombre_Usuario=?, Apellido_Usuario=?, Edad=?, " +
                    "Correo_Electronico=?, Telefono=?, Genero=?, ID_Estado=?, ID_Rol=?, Fotos=? WHERE Documento_Empleado=?";

            filas = jdbcTemplate.update(sql,
                    Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                    Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, nuevaUrl,
                    Documento_Empleado
            );

        } else {
            // Si NO viene foto: no tocar Fotos
            String sql = "UPDATE Empleados SET Tipo_Documento=?, Nombre_Usuario=?, Apellido_Usuario=?, Edad=?, " +
                    "Correo_Electronico=?, Telefono=?, Genero=?, ID_Estado=?, ID_Rol=? WHERE Documento_Empleado=?";

            filas = jdbcTemplate.update(sql,
                    Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                    Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol,
                    Documento_Empleado
            );
        }

        // Si viene contraseña -> upsert en Contrasenas
        if (Contrasena != null && !Contrasena.isBlank()) {
            upsertContrasena(Documento_Empleado, Contrasena);
        }

        return filas;
    }

    // ====================== ELIMINAR ======================
    @Transactional
    public int eliminarEmpleado(String Documento_Empleado) {
        try {
            // 1) Obtener valor Fotos actual
            String fotoActual = obtenerFotoActual(Documento_Empleado);

            // 2) Borrar archivo físico si existe
            borrarArchivoPorValorFotos(fotoActual);

            // 3) Eliminar contraseña primero (por FK/orden lógico)
            jdbcTemplate.update("DELETE FROM Contrasenas WHERE Documento_Empleado=?", Documento_Empleado);

            // 4) Eliminar empleado
            String sql = "DELETE FROM Empleados WHERE Documento_Empleado=?";
            return jdbcTemplate.update(sql, Documento_Empleado);

        } catch (Exception e) {
            e.printStackTrace();
            return 0;
        }
    }

    // ======================================================================
    // ============================ HELPERS =================================
    // ======================================================================

    // Upsert: si existe en Contrasenas -> UPDATE, si no -> INSERT
    private void upsertContrasena(String Documento_Empleado, String ContrasenaPlano) {
        Integer existe = jdbcTemplate.queryForObject(
                "SELECT COUNT(*) FROM Contrasenas WHERE Documento_Empleado=?",
                Integer.class,
                Documento_Empleado
        );

        if (existe != null && existe > 0) {
            jdbcTemplate.update(
                    "UPDATE Contrasenas SET Contrasena_Hash=? WHERE Documento_Empleado=?",
                    ContrasenaPlano, Documento_Empleado
            );
        } else {
            jdbcTemplate.update(
                    "INSERT INTO Contrasenas (Documento_Empleado, Contrasena_Hash) VALUES (?, ?)",
                    Documento_Empleado, ContrasenaPlano
            );
        }
    }

    // Obtener el valor actual de Fotos desde BD
    private String obtenerFotoActual(String Documento_Empleado) {
        try {
            String sqlFoto = "SELECT Fotos FROM Empleados WHERE Documento_Empleado=?";
            String val = jdbcTemplate.queryForObject(sqlFoto, String.class, Documento_Empleado);
            return val == null ? "" : val;
        } catch (Exception e) {
            return "";
        }
    }

    // Guardar archivo y devolver URL pública /uploads/...
    private String guardarArchivoYDevolverUrl(MultipartFile file, String documentoEmpleado) {
        try {
            if (!Files.exists(uploadsDir)) {
                Files.createDirectories(uploadsDir);
            }

            String original = StringUtils.cleanPath(file.getOriginalFilename() == null ? "file" : file.getOriginalFilename());

            String ext = "";
            int dot = original.lastIndexOf('.');
            if (dot != -1) ext = original.substring(dot);

            String safeDoc = documentoEmpleado == null ? "emp" : documentoEmpleado.replaceAll("[^A-Za-z0-9_-]", "_");
            String fileName = "empleado_" + safeDoc + "_" + System.currentTimeMillis() + ext;

            Path destino = uploadsDir.resolve(fileName);

            Files.copy(file.getInputStream(), destino, java.nio.file.StandardCopyOption.REPLACE_EXISTING);

            return ServletUriComponentsBuilder
                    .fromCurrentContextPath()
                    .path("/uploads/")
                    .path(fileName)
                    .toUriString();

        } catch (Exception e) {
            e.printStackTrace();
            return "";
        }
    }

    private void borrarArchivoPorValorFotos(String fotosValor) {
        try {
            if (fotosValor == null || fotosValor.isBlank()) return;

            if (fotosValor.contains("/uploads/")) {
                int idx = fotosValor.lastIndexOf("/uploads/");
                String fileName = fotosValor.substring(idx + "/uploads/".length());
                Path filePath = uploadsDir.resolve(fileName);
                if (Files.exists(filePath)) Files.delete(filePath);
                return;
            }

            Path path = Paths.get(fotosValor);
            if (Files.exists(path)) Files.delete(path);

        } catch (Exception ignored) {
        }
    }

    private String guardarBase64SiViene(String base64, String documento) {
        try {
            if (base64 == null || base64.isBlank()) return "";

            int coma = base64.indexOf(',');
            if (coma != -1) base64 = base64.substring(coma + 1);

            byte[] bytes = Base64.getDecoder().decode(base64);

            Path uploads = Paths.get("uploads");
            if (!Files.exists(uploads)) {
                Files.createDirectories(uploads);
            }

            String safeDoc = (documento == null ? "emp" : documento).replaceAll("[^A-Za-z0-9_-]", "_");
            String fileName = "empleado_" + safeDoc + "_" + System.currentTimeMillis() + ".jpg";

            Path destino = uploads.resolve(fileName);

            Files.write(destino, bytes);

            return "uploads/" + fileName;

        } catch (Exception e) {
            e.printStackTrace();
            return "";
        }
    }
}
