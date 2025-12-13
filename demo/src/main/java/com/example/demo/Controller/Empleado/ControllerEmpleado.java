package com.example.demo.Controller.Empleado;

import com.example.demo.DTO.Empleados.EmpleadosDTO;
import com.example.demo.Servicie.Empleados.ServiceEmpleados;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@Tag(name = "Empleado", description = "Operaciones sobre la tabla empleado")
public class ControllerEmpleado {

    @Autowired
    private ServiceEmpleados serviceEmpleados;

    @GetMapping("/Empleados")
    @Operation(summary = "Obtener Empleados",
            description = "Devuelve una lista con todos los Empleados almacenados en la tabla empleado.")
    public List<String> obtenerEmpleados() {
        return serviceEmpleados.obtenerEmpleados();
    }

    @PostMapping("/EmpleadoRegistro")
    @Operation(summary = "Registrar un nuevo empleado",
            description = "Crea un nuevo empleado en la tabla empleado a partir de los datos enviados en el cuerpo de la petición.")
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
                empleadoDTO.getFotos()
        );
        return "Empleado registrado correctamente";
    }

    @PutMapping("/EmpleadoActualizar/{Documento_Empleado}")
    @Operation(summary = "Actualizar un Empleado existente",
            description = "Modifica los datos de un Empleado según el ID proporcionado en la URL.")
    public String actualizarEmpleado(@PathVariable String Documento_Empleado, @RequestBody EmpleadosDTO empleadoDTO) {
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
                empleadoDTO.getFotos()
        );
        return filas > 0 ? "Empleado actualizado correctamente" : "Error al actualizar empleado";
    }

    @DeleteMapping("/EmpleadoEliminar/{Documento_Empleado}")
    @Operation(summary = "Eliminar un Empleado",
            description = "Elimina de forma permanente al Empleado que coincide con el ID proporcionado.")
    public String eliminarEmpleado(@PathVariable String Documento_Empleado) {
        int filas = serviceEmpleados.eliminarEmpleado(Documento_Empleado);
        return filas > 0 ? "Empleado eliminado correctamente" : "Error al eliminar empleado";
    }
}