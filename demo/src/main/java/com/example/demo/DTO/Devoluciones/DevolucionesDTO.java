package com.example.demo.DTO.Devoluciones;

import com.fasterxml.jackson.annotation.JsonProperty;

public class DevolucionesDTO {
    @JsonProperty ("ID_Devolucion")
    private String ID_Devolucion;
    @JsonProperty ("Fecha_Devolucion")
    private String Fecha_Devolucion;
    @JsonProperty("Motivo")
    private String Motivo;
    public DevolucionesDTO(){

    }

    public String getID_Devolucion() {
        return this.ID_Devolucion;
    }

    public void setID_Devolucion(String ID_Devolucion) {
        this.ID_Devolucion = ID_Devolucion;
    }

    public String getFecha_Devolucion() {
        return this.Fecha_Devolucion;
    }

    public void setFecha_Devolucion(String fecha_Devolucion) {
        this.Fecha_Devolucion = fecha_Devolucion;
    }

    public String getMotivo() {
        return this.Motivo;
    }

    public void setMotivo(String motivo) {
        this.Motivo = motivo;
    }
}
