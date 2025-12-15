package com.example.demo.Controller.Devoluciones;
import com.example.demo.DTO.Devoluciones.DevolucionesDTO;
import com.example.demo.Servicie.Devoluciones.DevolucionService;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;
import java.util.List;

@RestController
@Tag(name = "Devolucion", description = "Operaciones sobre la tabla devolucion")
public class DevolucionesController {

    @Autowired
    private DevolucionService devolucionService;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/Devoluciones")
    @Operation(summary = "Obtener devolucion",
            description = "Devuelve una lista con todos las devoluciones almacenados en la tabla devolucion.")
    public List<String> obtenerDevolucion() { return devolucionService.obtenerDevolucion();}

    @PostMapping("/AgregarDevolucion")
    @Operation(summary = "Registrar una nueva devolucion",
            description = "Crea una nueva devolucion en la tabla devolucion a partir de los datos enviados en el cuerpo de la petición.")
    public String agregarDevolucion (@RequestBody DevolucionesDTO devolucionesDTO){
        devolucionService.agregarDevolucion(
                devolucionesDTO.getID_Devolucion(),
                devolucionesDTO.getFecha_Devolucion(),
                devolucionesDTO.getMotivo()

        );
        return "La Devolucion se registro correctamente";
    }

    @PutMapping("/ActualizarD/{ID_Devolucion}")
    @Operation(summary = "Actualizar una devolucion existente",
            description = "Modifica los datos de una devolucion según el ID proporcionado en la URL.")
    public String actualizarDevolucion(@PathVariable("ID_Devolucion") String ID_Devolucion, @RequestBody DevolucionesDTO devolucionesDTO) {
        int filas = devolucionService.actualizarDevolucion(
                ID_Devolucion,
                devolucionesDTO.getFecha_Devolucion(),
                devolucionesDTO.getMotivo()
        );
        return "La Devolucion se ha actualizado correctamente";
    }

    @DeleteMapping("/EliminarDev/{ID_Devolucion}")
    @Operation(summary = "Eliminar una devolucion",
            description = "Elimina de forma permanente la devolucion que coincide con el ID proporcionado.")
    public String eliminarDevolucion(@PathVariable String ID_Devolucion) {
        int filas = devolucionService.eliminarDevolucion (ID_Devolucion);

        return   "Producto eliminado correctamente" ;
    }
}