package com.example.demo.Controller.Empleado;

import com.example.demo.DTO.Empleados.EmpleadosDTO;
import com.example.demo.Servicie.Empleados.ServiceEmpleados;
import com.fasterxml.jackson.databind.ObjectMapper;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import java.util.List;

@RestController
@Tag(name = "Empleado", description = "Operaciones sobre la tabla empleado")
public class ControllerEmpleado {

    @Autowired
    private ServiceEmpleados serviceEmpleados;

    // SOLO PARA MULTIPART
    @Autowired
    private ObjectMapper objectMapper;

    // ===================== OBTENER =====================
    @GetMapping("/Empleados")
    @Operation(
            summary = "Obtener Empleados",
            description = "Devuelve una lista con todos los Empleados."
    )
    public List<String> obtenerEmpleados() {
        return serviceEmpleados.obtenerEmpleados();
    }

    // ===================== REGISTRO NORMAL (JSON) =====================
    @PostMapping("/EmpleadoRegistro")
    @Operation(
            summary = "Registrar un nuevo empleado",
            description = "Crea un nuevo empleado usando JSON (base64 opcional en Fotos)."
    )
    public String agregarEmpleado(@RequestBody EmpleadosDTO empleadoDTO) {

        serviceEmpleados.agregarEmpleado(
                empleadoDTO.getDocumento_Empleado(),
                empleadoDTO.getTipo_Documento(),
                empleadoDTO.getNombre_Usuario(),
                empleadoDTO.getApellido_Usuario(),
                empleadoDTO.getEdad(),
                empleadoDTO.getCorreo_Electronico(),
                empleadoDTO.getTelefono(),
                empleadoDTO.getGenero(),
                empleadoDTO.getID_Estado(),
                empleadoDTO.getID_Rol(),
                empleadoDTO.getFotos(),
                empleadoDTO.getContrasena()   // 🔐 CLAVE
        );

        return "Empleado registrado correctamente";
    }

    // ===================== ACTUALIZAR NORMAL =====================
    @PutMapping("/EmpleadoActualizar/{Documento_Empleado}")
    @Operation(
            summary = "Actualizar un Empleado existente",
            description = "Modifica los datos de un Empleado usando JSON."
    )
    public String actualizarEmpleado(
            @PathVariable String Documento_Empleado,
            @RequestBody EmpleadosDTO empleadoDTO
    ) {

        int filas = serviceEmpleados.actualizarEmpleado(
                Documento_Empleado,
                empleadoDTO.getTipo_Documento(),
                empleadoDTO.getNombre_Usuario(),
                empleadoDTO.getApellido_Usuario(),
                empleadoDTO.getEdad(),
                empleadoDTO.getCorreo_Electronico(),
                empleadoDTO.getTelefono(),
                empleadoDTO.getGenero(),
                empleadoDTO.getID_Estado(),
                empleadoDTO.getID_Rol(),
                empleadoDTO.getFotos(),
                empleadoDTO.getContrasena() // 🔐 opcional
        );

        return filas > 0
                ? "Empleado actualizado correctamente"
                : "Error al actualizar empleado";
    }

    // ===================== ELIMINAR =====================
    @DeleteMapping("/EmpleadoEliminar/{Documento_Empleado}")
    @Operation(
            summary = "Eliminar un Empleado",
            description = "Elimina de forma permanente al Empleado."
    )
    public String eliminarEmpleado(@PathVariable String Documento_Empleado) {
        int filas = serviceEmpleados.eliminarEmpleado(Documento_Empleado);
        return filas > 0 ? "Empleado eliminado correctamente" : "Error al eliminar empleado";
    }

    // =================================================================
    // ===================== MULTIPART ================================
    // =================================================================

    // ===================== REGISTRO MULTIPART =====================
    @PostMapping(
            value = "/EmpleadoRegistroMultipart",
            consumes = MediaType.MULTIPART_FORM_DATA_VALUE
    )
    @Operation(
            summary = "Registrar empleado (multipart)",
            description = "Registra un empleado enviando 'data' (JSON) y 'file' (imagen)."
    )
    public String agregarEmpleadoMultipart(
            @RequestPart("data") String dataJson,
            @RequestPart(value = "file", required = false) MultipartFile file
    ) throws Exception {

        EmpleadosDTO data = objectMapper.readValue(dataJson, EmpleadosDTO.class);

        serviceEmpleados.agregarEmpleadoMultipart(
                data.getDocumento_Empleado(),
                data.getTipo_Documento(),
                data.getNombre_Usuario(),
                data.getApellido_Usuario(),
                data.getEdad(),
                data.getCorreo_Electronico(),
                data.getTelefono(),
                data.getGenero(),
                data.getID_Estado(),
                data.getID_Rol(),
                file,
                data.getContrasena() // 🔐 CLAVE
        );

        return "Empleado registrado correctamente (multipart)";
    }

    // ===================== ACTUALIZAR MULTIPART =====================
    @PutMapping(
            value = "/EmpleadoActualizarMultipart/{Documento_Empleado}",
            consumes = MediaType.MULTIPART_FORM_DATA_VALUE
    )
    @Operation(
            summary = "Actualizar empleado (multipart)",
            description = "Actualiza un empleado enviando 'data' (JSON) y 'file' (imagen)."
    )
    public String actualizarEmpleadoMultipart(
            @PathVariable String Documento_Empleado,
            @RequestPart("data") String dataJson,
            @RequestPart(value = "file", required = false) MultipartFile file
    ) throws Exception {

        EmpleadosDTO data = objectMapper.readValue(dataJson, EmpleadosDTO.class);

        int filas = serviceEmpleados.actualizarEmpleadoMultipart(
                Documento_Empleado,
                data.getTipo_Documento(),
                data.getNombre_Usuario(),
                data.getApellido_Usuario(),
                data.getEdad(),
                data.getCorreo_Electronico(),
                data.getTelefono(),
                data.getGenero(),
                data.getID_Estado(),
                data.getID_Rol(),
                file,
                data.getContrasena() // 🔐 opcional
        );

        return filas > 0
                ? "Empleado actualizado correctamente (multipart)"
                : "Error al actualizar empleado";
    }
}
