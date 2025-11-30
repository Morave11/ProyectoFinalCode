package com.example.demo.Autenticar;

import com.fasterxml.jackson.annotation.JsonProperty;

public class LoginRequest {

    @JsonProperty("documento_Empleado")   // nombre del campo que vas a mandar desde Laravel
    private String documentoEmpleado;

    @JsonProperty("contrasena")          // contraseña en texto plano
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
