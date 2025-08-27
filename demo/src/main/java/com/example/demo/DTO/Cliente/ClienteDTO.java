package com.example.demo.DTO.Cliente;

import com.fasterxml.jackson.annotation.JsonProperty;

public class ClienteDTO {

    @JsonProperty("Documento_Cliente")
    private String Documento_Cliente;

    @JsonProperty("Nombre_Cliente")
    private String Nombre_Cliente;

    @JsonProperty("Apellido_Cliente")
    private String Apellido_Cliente;

    @JsonProperty("Telefono")
    private String Telefono;

    @JsonProperty("Fecha_Nacimiento")
    private String Fecha_Nacimiento; // YYYY-MM-DD

    @JsonProperty("Genero")
    private String Genero; // 'M' o 'F'

    @JsonProperty("ID_Estado")
    private String ID_Estado;

    public ClienteDTO() {
    }

    // Getters
    public String getDocumento_Cliente() { return this.Documento_Cliente; }
    public String getNombre_Cliente()    { return this.Nombre_Cliente; }
    public String getApellido_Cliente()  { return this.Apellido_Cliente; }
    public String getTelefono()          { return this.Telefono; }
    public String getFecha_Nacimiento()  { return this.Fecha_Nacimiento; }
    public String getGenero()            { return this.Genero; }
    public String getID_Estado()         { return this.ID_Estado; }

    // Setters (usando this y evitando sombreado)
    public void setDocumento_Cliente(String documento_Cliente) { this.Documento_Cliente = documento_Cliente; }
    public void setNombre_Cliente(String nombre_Cliente)       { this.Nombre_Cliente = nombre_Cliente; }
    public void setApellido_Cliente(String apellido_Cliente)   { this.Apellido_Cliente = apellido_Cliente; }
    public void setTelefono(String telefono)                   { this.Telefono = telefono; }
    public void setFecha_Nacimiento(String fecha_Nacimiento)   { this.Fecha_Nacimiento = fecha_Nacimiento; }
    public void setGenero(String genero)                       { this.Genero = genero; }
    public void setID_Estado(String id_Estado)                 { this.ID_Estado = id_Estado; }
}