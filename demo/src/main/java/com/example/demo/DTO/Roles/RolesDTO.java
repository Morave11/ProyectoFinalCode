package com.example.demo.DTO.Roles;

import com.fasterxml.jackson.annotation.JsonProperty;

public class RolesDTO {
    @JsonProperty("ID_Rol")
    private String ID_Rol;
    @JsonProperty("Nombre")
    private String Nombre;

    public RolesDTO() {

    }

    public String getID_Rol() {
        return this.ID_Rol;
    }

    public void setID_Rol(String ID_Rol) {
        this.ID_Rol = ID_Rol;
    }

    public String getNombre() {
        return this.Nombre;
    }

    public void setNombre(String nombre) {
        this.Nombre = nombre;
    }
}
