package com.example.demo.DTO.Estados;

import com.fasterxml.jackson.annotation.JsonProperty;

public class EstadosDTO {
    @JsonProperty ("ID_Estado")
    private String ID_Estado;
    @JsonProperty ("Nombre_Estado")
    private String Nombre_Estado;

    public EstadosDTO() {
    }

    public String getID_Estado() {
        return this.ID_Estado;
    }

    public void setID_Estado(String ID_Estado) {
        this.ID_Estado = ID_Estado;
    }

    public String getNombre_Estado() {
        return this.Nombre_Estado;
    }

    public void setNombre_Estado(String nombre_Estado) {
        this.Nombre_Estado = nombre_Estado;
    }
}
