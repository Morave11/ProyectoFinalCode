package com.example.demo.DTO.Categorias;

import com.fasterxml.jackson.annotation.JsonProperty;

public class CategoriasDTO {
    @JsonProperty("ID_Categoria")
    private String ID_Categoria;
    @JsonProperty("Nombre_Categoria")
    private String Nombre_Categoria;


    public CategoriasDTO() {
    }

    public String getID_Categoria() {
        return this.ID_Categoria;
    }

    public void setID_Categoria(String ID_Categoria) {
        this.ID_Categoria = ID_Categoria;
    }

    public String getNombre_Categoria() {
        return this.Nombre_Categoria;
    }

    public void setNombre_Categoria(String nombre_Categoria) {
        this.Nombre_Categoria = nombre_Categoria;
    }
}
