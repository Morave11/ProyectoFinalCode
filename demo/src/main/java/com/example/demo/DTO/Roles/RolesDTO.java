package com.example.demo.DTO.Roles;

import com.fasterxml.jackson.annotation.JsonProperty;

public class RolesDTO {
    @JsonProperty("ID_Role")
    private String ID_Role;
    @JsonProperty("Nombre")
    private String Nombre;

    public RolesDTO() {

    }

    public String getID_Role() {
        return this.ID_Role;
    }

    public void setID_Role(String ID_Role) {
        this.ID_Role = ID_Role;
    }

    public String getNombre() {
        return this.Nombre;
    }

    public void setNombre(String nombre) {
        this.Nombre = nombre;
    }
}
