package com.example.demo.Autenticar;

import com.fasterxml.jackson.annotation.JsonProperty;

public class LoginRequest {

    @JsonProperty("documento_Empleado")
    private String documentoEmpleado;

    @JsonProperty("contrasena")
    private String contrasena;

    public String getDocumentoEmpleado() {
        return documentoEmpleado;
    }

    public void setDocumentoEmpleado(String documentoEmpleado) {
        this.documentoEmpleado = documentoEmpleado;
    }

    public String getContrasena() {
        return contrasena;
    }

    public void setContrasena(String contrasena) {
        this.contrasena = contrasena;
    }
}
