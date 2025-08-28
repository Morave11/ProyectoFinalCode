package com.example.demo.DTO.Contraseñas;

import com.fasterxml.jackson.annotation.JsonProperty;

public class ContraseñaDTO {
    @JsonProperty("ID_Contrasena")
    private String ID_Contrasena;
    @JsonProperty ("Documento_Empleado")
    private String Documento_Empleado;
    @JsonProperty ("Contrasena_Hash")
    private String Contrasena_Hash;

    public ContraseñaDTO(){
    }

    public String getFecha_Creacion() {
        return this.Fecha_Creacion;
    }

    public void setFecha_Creacion(String fecha_Creacion) {
        this.Fecha_Creacion = fecha_Creacion;
    }

    public String getContrasena_Hash() {
        return this.Contrasena_Hash;
    }

    public void setContrasena_Hash(String contrasena_Hash) {
        this.Contrasena_Hash = contrasena_Hash;
    }

    public String getDocumento_Empleado() {
        return this.Documento_Empleado;
    }

    public void setDocumento_Empleado(String documento_Empleado) {
        this.Documento_Empleado = documento_Empleado;
    }

    public String getID_Contrasena() {
        return this.ID_Contrasena;
    }

    public void setID_Contrasena(String ID_Contrasena) {
        this.ID_Contrasena = ID_Contrasena;
    }

    private String Fecha_Creacion;
}
