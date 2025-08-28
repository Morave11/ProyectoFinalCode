package com.example.demo.DTO.Gamas;

import com.fasterxml.jackson.annotation.JsonProperty;

public class GamasDTO {
    @JsonProperty("ID_Gama")
    private String ID_Gama;
    @JsonProperty("Nombre_Gama")
    private String Nombre_Gama;
    public GamasDTO() {

    }

    public String getID_Gama() {
        return this.ID_Gama;
    }

    public void setID_Gama(String ID_Gama) {
        this.ID_Gama = ID_Gama;
    }

    public String getNombre_Gama() {
        return this.Nombre_Gama;
    }

    public void setNombre_Gama(String nombre_Gama) {
        this.Nombre_Gama = nombre_Gama;
    }
}
