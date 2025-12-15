package com.example.demo.Controller;

import org.springframework.http.ResponseEntity;
import org.springframework.util.StringUtils;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;
import org.springframework.web.servlet.support.ServletUriComponentsBuilder;

import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.StandardCopyOption;

@RestController
@CrossOrigin(origins = "*")
public class UploadController {

    private final Path uploadsDir = Paths.get("uploads");

    @PostMapping("/upload")
    public ResponseEntity<?> upload(@RequestParam("file") MultipartFile file) {
        try {
            if (file == null || file.isEmpty()) {
                return ResponseEntity.badRequest().body("Archivo vacío");
            }

            if (!Files.exists(uploadsDir)) {
                Files.createDirectories(uploadsDir);
            }

            String original = StringUtils.cleanPath(file.getOriginalFilename() == null ? "file" : file.getOriginalFilename());
            String ext = "";

            int dot = original.lastIndexOf('.');
            if (dot != -1) ext = original.substring(dot);

            String fileName = "img_" + System.currentTimeMillis() + ext;
            Path destino = uploadsDir.resolve(fileName);

            Files.copy(file.getInputStream(), destino, StandardCopyOption.REPLACE_EXISTING);

            String publicUrl = ServletUriComponentsBuilder
                    .fromCurrentContextPath()
                    .path("/uploads/")
                    .path(fileName)
                    .toUriString();

            return ResponseEntity.ok(publicUrl);

        } catch (Exception e) {
            e.printStackTrace();
            return ResponseEntity.internalServerError().body("Error subiendo archivo: " + e.getMessage());
        }
    }
}
