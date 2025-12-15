package com.example.demo.DTO.Empleados;

import com.fasterxml.jackson.annotation.JsonProperty;

public class EmpleadosDTO {

    @JsonProperty("Documento_Empleado")
    private String Documento_Empleado;

    @JsonProperty("Tipo_Documento")
    private String Tipo_Documento;

    @JsonProperty("Nombre_Usuario")
    private String Nombre_Usuario;

    @JsonProperty("Apellido_Usuario")
    private String Apellido_Usuario;

    @JsonProperty("Edad")
    private String Edad;

    @JsonProperty("Correo_Electronico")
    private String Correo_Electronico;

    @JsonProperty("Telefono")
    private String Telefono;

    @JsonProperty("Genero")
    private String Genero;

    @JsonProperty("ID_Estado")
    private String ID_Estado;

    @JsonProperty("ID_Rol")
    private String ID_Rol;

    @JsonProperty("Fotos")
    private String Fotos;

    @JsonProperty("Contrasena")
    private String Contrasena;

    public EmpleadosDTO() {}

    public String getDocumento_Empleado() {
        return this.Documento_Empleado;
    }

    public void setDocumento_Empleado(String documento_Empleado) {
        this.Documento_Empleado = documento_Empleado;
    }

    public String getTipo_Documento() {
        return this.Tipo_Documento;
    }

    public void setTipo_Documento(String tipo_Documento) {
        this.Tipo_Documento = tipo_Documento;
    }

    public String getNombre_Usuario() {
        return this.Nombre_Usuario;
    }

    public void setNombre_Usuario(String nombre_Usuario) {
        this.Nombre_Usuario = nombre_Usuario;
    }

    public String getApellido_Usuario() {
        return this.Apellido_Usuario;
    }

    public void setApellido_Usuario(String apellido_Usuario) {
        this.Apellido_Usuario = apellido_Usuario;
    }

    public String getEdad() {
        return this.Edad;
    }

    public void setEdad(String edad) {
        this.Edad = edad;
    }

    public String getCorreo_Electronico() {
        return this.Correo_Electronico;
    }

    public void setCorreo_Electronico(String correo_Electronico) {
        this.Correo_Electronico = correo_Electronico;
    }

    public String getTelefono() {
        return this.Telefono;
    }

    public void setTelefono(String telefono) {
        this.Telefono = telefono;
    }

    public String getGenero() {
        return this.Genero;
    }

    public void setGenero(String genero) {
        this.Genero = genero;
    }

    public String getID_Estado() {
        return this.ID_Estado;
    }

    public void setID_Estado(String ID_Estado) {
        this.ID_Estado = ID_Estado;
    }

    public String getID_Rol() {
        return this.ID_Rol;
    }

    public void setID_Rol(String ID_Rol) {
        this.ID_Rol = ID_Rol;
    }

    public String getFotos() {
        return this.Fotos;
    }

    public void setFotos(String fotos) {
        this.Fotos = fotos;
    }


    public String getContrasena() {
        return this.Contrasena;
    }

    public void setContrasena(String contrasena) {
        this.Contrasena = contrasena;
    }
}
