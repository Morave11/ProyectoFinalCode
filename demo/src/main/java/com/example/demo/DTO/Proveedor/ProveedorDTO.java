package com.example.demo.DTO.Proveedor;

import com.fasterxml.jackson.annotation.JsonProperty;

public class ProveedorDTO {

    @JsonProperty("ID_Proveedor")
    private String ID_Proveedor;

    @JsonProperty("Nombre_Proveedor")
    private String Nombre_Proveedor;

    @JsonProperty("Correo_Electronico")
    private String Correo_Electronico;

    @JsonProperty("Telefono")
    private String Telefono;

    @JsonProperty("ID_Estado")
    private String ID_Estado;

    public ProveedorDTO() {}


    public String getID_Proveedor()        { return this.ID_Proveedor; }
    public String getNombre_Proveedor()    { return this.Nombre_Proveedor; }
    public String getCorreo_Electronico()  { return this.Correo_Electronico; }
    public String getTelefono()            { return this.Telefono; }
    public String getID_Estado()           { return this.ID_Estado; }


    public void setID_Proveedor(String ID_Proveedor)            { this.ID_Proveedor = ID_Proveedor; }
    public void setNombre_Proveedor(String nombre_Proveedor)    { this.Nombre_Proveedor = nombre_Proveedor; }
    public void setCorreo_Electronico(String correo_Electronico){ this.Correo_Electronico = correo_Electronico; }
    public void setTelefono(String telefono)                    { this.Telefono = telefono; }
    public void setID_Estado(String ID_Estado)                  { this.ID_Estado = ID_Estado; }
}