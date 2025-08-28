package com.example.demo.Controller.Devoluciones;
import com.example.demo.DTO.Devoluciones.DevolucionesDTO;
import com.example.demo.Servicie.Devoluciones.DevolucionService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.*;
import java.util.List;

@RestController
public class DevolucionesController {

    @Autowired
    private DevolucionService devolucionService;
    @Autowired
    JdbcTemplate jdbcTemplate;

    @GetMapping("/Devoluciones")
    public List<String> obtenerDevolucion() { return devolucionService.obtenerDevolucion();}


    @PostMapping("/AgregarDevolucion")
    public String agregarDevolucion (@RequestBody DevolucionesDTO devolucionesDTO){
        devolucionService.agregarDevolucion(
                devolucionesDTO.getID_Devolucion(),
                devolucionesDTO.getFecha_Devolucion(),
                devolucionesDTO.getMotivo()

        );
        return "La Devolucion se registro correctamente";
    }


    @PutMapping("/Actualizar/{ID_Devolucion}")
    public String actualizarDevolucion(@PathVariable("ID_Devolucion") String ID_Devolucion, @RequestBody DevolucionesDTO devolucionesDTO) {
        int filas = devolucionService.actualizarDevolucion(
                ID_Devolucion,
                devolucionesDTO.getFecha_Devolucion(),
                devolucionesDTO.getMotivo()
        );
        return "La Devolucion se ha actualizado correctamente";
    }

    @DeleteMapping("/EliminarDev/{ID_Devolucion}")
    public String eliminarDevolucion(@PathVariable String ID_Devolucion) {
        int filas = devolucionService.eliminarDevolucion (ID_Devolucion);

        return   "Producto eliminado correctamente" ;
    }
}