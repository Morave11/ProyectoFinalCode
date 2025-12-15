package com.example.demo.Servicie.Producto;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.util.StringUtils;
import org.springframework.web.multipart.MultipartFile;
import org.springframework.web.servlet.support.ServletUriComponentsBuilder;

import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Base64;
import java.util.List;

@Service
public class ProductoServicie {

    @Autowired
    private JdbcTemplate jdbcTemplate;

    private final Path uploadsDir = Paths.get("uploads");

    public List<String> ObtenerProductos() {
        String sql = "SELECT ID_Producto,Nombre_Producto,Descripcion,Precio_Venta,Stock_Minimo,ID_Categoria,ID_Estado,ID_Gama,Fotos FROM productos";
        return jdbcTemplate.query(sql, new RowMapper<String>() {
            @Override
            public String mapRow(ResultSet rs, int rowNum) throws SQLException {
                return rs.getString("ID_Producto") +
                        "________" + rs.getString("Nombre_Producto") +
                        "________" + rs.getString("Descripcion") +
                        "________" + rs.getString("Precio_Venta") +
                        "________" + rs.getString("Stock_Minimo") +
                        "________" + rs.getString("ID_Categoria") +
                        "________" + rs.getString("ID_Estado") +
                        "________" + rs.getString("ID_Gama") +
                        "________" + (rs.getString("Fotos") == null ? "" : rs.getString("Fotos"));
            }
        });
    }

    public void AgregarProductos(String ID_Producto, String Nombre_Producto, String Descripcion,
                                 String Precio_Venta, String Stock_Minimo, String ID_Categoria,
                                 String ID_Estado, String ID_Gama, String Fotos) {

        Fotos = guardarBase64SiViene(Fotos, ID_Producto);

        String sql = "INSERT INTO productos (ID_Producto,Nombre_Producto,Descripcion,Precio_Venta,Stock_Minimo,ID_Categoria,ID_Estado,ID_Gama,Fotos) VALUES (?,?,?,?,?,?,?,?,?)";
        jdbcTemplate.update(sql, ID_Producto, Nombre_Producto, Descripcion, Precio_Venta, Stock_Minimo, ID_Categoria, ID_Estado, ID_Gama, Fotos);
    }

    public int actualizarProductos(String ID_Producto, String Nombre_Producto, String Descripcion,
                                   String Precio_Venta, String Stock_Minimo, String ID_Categoria,
                                   String ID_Estado, String ID_Gama, String Fotos) {

        if (Fotos == null || Fotos.isBlank()) {
            String sql = "UPDATE productos SET Nombre_Producto = ?, Descripcion = ?, Precio_Venta = ?, Stock_Minimo = ?, " +
                    "ID_Categoria = ?, ID_Estado = ?, ID_Gama = ? WHERE ID_Producto = ?";
            return jdbcTemplate.update(sql, Nombre_Producto, Descripcion, Precio_Venta, Stock_Minimo, ID_Categoria, ID_Estado, ID_Gama, ID_Producto);
        }

        Fotos = guardarBase64SiViene(Fotos, ID_Producto);

        String sql = "UPDATE productos SET Nombre_Producto = ?, Descripcion = ?, Precio_Venta = ?, Stock_Minimo = ?, " +
                "ID_Categoria = ?, ID_Estado = ?, ID_Gama = ?, Fotos = ? WHERE ID_Producto = ?";
        return jdbcTemplate.update(sql, Nombre_Producto, Descripcion, Precio_Venta, Stock_Minimo, ID_Categoria, ID_Estado, ID_Gama, Fotos, ID_Producto);
    }

    public int EliminarProductos(String ID_Producto) {
        String sql = "DELETE FROM productos WHERE ID_Producto = ?";
        return jdbcTemplate.update(sql, ID_Producto);
    }

    public void AgregarProductosMultipart(String ID_Producto, String Nombre_Producto, String Descripcion,
                                          String Precio_Venta, String Stock_Minimo, String ID_Categoria,
                                          String ID_Estado, String ID_Gama, MultipartFile file) {

        String fotosUrl = "";

        if (file != null && !file.isEmpty()) {
            fotosUrl = guardarArchivoYDevolverUrl(file, ID_Producto);
        }

        String sql = "INSERT INTO productos (ID_Producto,Nombre_Producto,Descripcion,Precio_Venta,Stock_Minimo,ID_Categoria,ID_Estado,ID_Gama,Fotos) VALUES (?,?,?,?,?,?,?,?,?)";
        jdbcTemplate.update(sql, ID_Producto, Nombre_Producto, Descripcion, Precio_Venta, Stock_Minimo, ID_Categoria, ID_Estado, ID_Gama, fotosUrl);
    }

    public int actualizarProductosMultipart(String ID_Producto, String Nombre_Producto, String Descripcion,
                                            String Precio_Venta, String Stock_Minimo, String ID_Categoria,
                                            String ID_Estado, String ID_Gama, MultipartFile file) {

        int filas;

        if (file != null && !file.isEmpty()) {
            String nuevaUrl = guardarArchivoYDevolverUrl(file, ID_Producto);

            String sql = "UPDATE productos SET Nombre_Producto = ?, Descripcion = ?, Precio_Venta = ?, Stock_Minimo = ?, " +
                    "ID_Categoria = ?, ID_Estado = ?, ID_Gama = ?, Fotos = ? WHERE ID_Producto = ?";

            filas = jdbcTemplate.update(sql, Nombre_Producto, Descripcion, Precio_Venta, Stock_Minimo, ID_Categoria, ID_Estado, ID_Gama, nuevaUrl, ID_Producto);

        } else {
            String sql = "UPDATE productos SET Nombre_Producto = ?, Descripcion = ?, Precio_Venta = ?, Stock_Minimo = ?, " +
                    "ID_Categoria = ?, ID_Estado = ?, ID_Gama = ? WHERE ID_Producto = ?";

            filas = jdbcTemplate.update(sql, Nombre_Producto, Descripcion, Precio_Venta, Stock_Minimo, ID_Categoria, ID_Estado, ID_Gama, ID_Producto);
        }

        return filas;
    }

    private String guardarBase64SiViene(String base64, String idProducto) {
        try {
            if (base64 == null || base64.isBlank()) return "";

            int coma = base64.indexOf(',');
            if (coma != -1) base64 = base64.substring(coma + 1);

            byte[] bytes = Base64.getDecoder().decode(base64);

            if (!Files.exists(uploadsDir)) {
                Files.createDirectories(uploadsDir);
            }

            String safeId = (idProducto == null ? "prod" : idProducto).replaceAll("[^A-Za-z0-9_-]", "_");
            String fileName = "producto_" + safeId + "_" + System.currentTimeMillis() + ".jpg";
            Path destino = uploadsDir.resolve(fileName);

            Files.write(destino, bytes);

            return ServletUriComponentsBuilder
                    .fromCurrentContextPath()
                    .path("/")
                    .path(fileName)
                    .toUriString();

        } catch (Exception e) {
            e.printStackTrace();
            return "";
        }
    }

    private String guardarArchivoYDevolverUrl(MultipartFile file, String idProducto) {
        try {
            if (!Files.exists(uploadsDir)) {
                Files.createDirectories(uploadsDir);
            }

            String original = StringUtils.cleanPath(file.getOriginalFilename() == null ? "file" : file.getOriginalFilename());

            String ext = "";
            int dot = original.lastIndexOf('.');
            if (dot != -1) ext = original.substring(dot);

            String safeId = (idProducto == null ? "prod" : idProducto).replaceAll("[^A-Za-z0-9_-]", "_");
            String fileName = "producto_" + safeId + "_" + System.currentTimeMillis() + ext;
            Path destino = uploadsDir.resolve(fileName);

            Files.copy(file.getInputStream(), destino, java.nio.file.StandardCopyOption.REPLACE_EXISTING);

            return ServletUriComponentsBuilder
                    .fromCurrentContextPath()
                    .path("/")
                    .path(fileName)
                    .toUriString();

        } catch (Exception e) {
            e.printStackTrace();
            return "";
        }
    }
}
