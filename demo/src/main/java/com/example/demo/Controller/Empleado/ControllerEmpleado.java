package com.example.demo.Controller.Empleado;

import com.example.demo.DTO.Empleados.EmpleadosDTO;
import com.example.demo.Servicie.Empleados.ServiceEmpleados;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class ControllerEmpleado {

    @Autowired
    private ServiceEmpleados serviceEmpleados;

    @GetMapping("/Empleados")
    public List<String> obtenerEmpleados() {
        return serviceEmpleados.obtenerEmpleados();
    }

    @PostMapping("/EmpleadoRegistro")
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
    public String eliminarEmpleado(@PathVariable String Documento_Empleado) {
        int filas = serviceEmpleados.eliminarEmpleado(Documento_Empleado);
        return filas > 0 ? "Empleado eliminado correctamente" : "Error al eliminar empleado";
    }
}