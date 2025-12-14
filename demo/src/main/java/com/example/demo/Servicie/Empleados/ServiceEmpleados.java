package com.example.demo.Servicie.Empleados;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;
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

    // ---------------------- OBTENER ----------------------
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

    // ---------------------- INSERTAR (JSON / BASE64) ----------------------
    public void agregarEmpleado(String Documento_Empleado, String Tipo_Documento, String Nombre_Usuario,
                                String Apellido_Usuario, String Edad, String Correo_Electronico,
                                String Telefono, String Genero, String ID_Estado, String ID_Rol, String Fotos) {

        Fotos = guardarBase64SiViene(Fotos, Documento_Empleado);

        String sql = "INSERT INTO Empleados (Documento_Empleado, Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad, Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, Fotos) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        jdbcTemplate.update(sql, Documento_Empleado, Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, Fotos);
    }

    // ---------------------- ACTUALIZAR (JSON / BASE64) ----------------------
    public int actualizarEmpleado(String Documento_Empleado, String Tipo_Documento, String Nombre_Usuario,
                                  String Apellido_Usuario, String Edad, String Correo_Electronico,
                                  String Telefono, String Genero, String ID_Estado, String ID_Rol, String Fotos) {

        // 1. Si NO viene foto nueva → no tocar la columna Fotos
        if (Fotos == null || Fotos.isBlank()) {

            String sql = "UPDATE Empleados SET Tipo_Documento=?, Nombre_Usuario=?, Apellido_Usuario=?, Edad=?, " +
                    "Correo_Electronico=?, Telefono=?, Genero=?, ID_Estado=?, ID_Rol=? WHERE Documento_Empleado=?";

            return jdbcTemplate.update(sql,
                    Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                    Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol,
                    Documento_Empleado
            );
        }

        // 2. Si viene Base64 → guardar archivo y actualizar columna
        Fotos = guardarBase64SiViene(Fotos, Documento_Empleado);

        String sql = "UPDATE Empleados SET Tipo_Documento=?, Nombre_Usuario=?, Apellido_Usuario=?, Edad=?, " +
                "Correo_Electronico=?, Telefono=?, Genero=?, ID_Estado=?, ID_Rol=?, Fotos=? WHERE Documento_Empleado=?";

        return jdbcTemplate.update(sql,
                Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, Fotos,
                Documento_Empleado
        );
    }

    // ======================================================================
    // ======================= NUEVO: MULTIPART =============================
    // ======================================================================

    // ---------------------- INSERTAR (MULTIPART) ----------------------
    public void agregarEmpleadoMultipart(String Documento_Empleado, String Tipo_Documento, String Nombre_Usuario,
                                         String Apellido_Usuario, String Edad, String Correo_Electronico,
                                         String Telefono, String Genero, String ID_Estado, String ID_Rol,
                                         MultipartFile file) {

        String fotosUrl = "";

        if (file != null && !file.isEmpty()) {
            fotosUrl = guardarArchivoYDevolverUrl(file, Documento_Empleado);
        }

        String sql = "INSERT INTO Empleados (Documento_Empleado, Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad, Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, Fotos) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        jdbcTemplate.update(sql, Documento_Empleado, Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, fotosUrl);
    }

    // ---------------------- ACTUALIZAR (MULTIPART) ----------------------
    public int actualizarEmpleadoMultipart(String Documento_Empleado, String Tipo_Documento, String Nombre_Usuario,
                                           String Apellido_Usuario, String Edad, String Correo_Electronico,
                                           String Telefono, String Genero, String ID_Estado, String ID_Rol,
                                           MultipartFile file) {

        // Si viene foto nueva: borrar anterior + guardar nueva + actualizar Fotos
        if (file != null && !file.isEmpty()) {

            String fotoActual = obtenerFotoActual(Documento_Empleado);
            borrarArchivoPorValorFotos(fotoActual); // funciona si era URL o ruta

            String nuevaUrl = guardarArchivoYDevolverUrl(file, Documento_Empleado);

            String sql = "UPDATE Empleados SET Tipo_Documento=?, Nombre_Usuario=?, Apellido_Usuario=?, Edad=?, " +
                    "Correo_Electronico=?, Telefono=?, Genero=?, ID_Estado=?, ID_Rol=?, Fotos=? WHERE Documento_Empleado=?";

            return jdbcTemplate.update(sql,
                    Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                    Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol, nuevaUrl,
                    Documento_Empleado
            );
        }

        // Si NO viene foto: no tocar Fotos
        String sql = "UPDATE Empleados SET Tipo_Documento=?, Nombre_Usuario=?, Apellido_Usuario=?, Edad=?, " +
                "Correo_Electronico=?, Telefono=?, Genero=?, ID_Estado=?, ID_Rol=? WHERE Documento_Empleado=?";

        return jdbcTemplate.update(sql,
                Tipo_Documento, Nombre_Usuario, Apellido_Usuario, Edad,
                Correo_Electronico, Telefono, Genero, ID_Estado, ID_Rol,
                Documento_Empleado
        );
    }

    // ---------------------- ELIMINAR ----------------------
    public int eliminarEmpleado(String Documento_Empleado) {
        try {
            // 1) Obtener valor Fotos actual (puede ser URL o ruta)
            String fotoActual = obtenerFotoActual(Documento_Empleado);

            // 2) Borrar archivo físico si existe
            borrarArchivoPorValorFotos(fotoActual);

            // 3) Eliminar empleado
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

            // Si existe, lo reemplaza
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

    /**
     * Borra el archivo físico usando el valor guardado en Fotos.
     * - Si Fotos era "uploads/xxx.jpg" -> borra directo.
     * - Si Fotos era "http://IP:8080/uploads/xxx.jpg" -> extrae xxx.jpg y borra.
     */
    private void borrarArchivoPorValorFotos(String fotosValor) {
        try {
            if (fotosValor == null || fotosValor.isBlank()) return;

            // Caso 1: si es URL tipo http://.../uploads/archivo.jpg
            if (fotosValor.contains("/uploads/")) {
                int idx = fotosValor.lastIndexOf("/uploads/");
                String fileName = fotosValor.substring(idx + "/uploads/".length());
                Path filePath = uploadsDir.resolve(fileName);
                if (Files.exists(filePath)) Files.delete(filePath);
                return;
            }

            // Caso 2: si es ruta tipo uploads/archivo.jpg
            Path path = Paths.get(fotosValor);
            if (Files.exists(path)) Files.delete(path);

        } catch (Exception ignored) {
        }
    }

    // ---------------------- GUARDAR FOTO (BASE64) ----------------------
    private String guardarBase64SiViene(String base64, String documento) {
        try {
            if (base64 == null || base64.isBlank()) return "";

            // Remover prefijo data:image/... si viene
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

            // ✅ Guardar ruta RELATIVA web-friendly (siempre con /)
            return "uploads/" + fileName;

        } catch (Exception e) {
            e.printStackTrace();
            return "";
        }
    }
    }