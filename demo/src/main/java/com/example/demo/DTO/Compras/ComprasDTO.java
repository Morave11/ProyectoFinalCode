package com.example.demo.DTO.Compras;

import com.fasterxml.jackson.annotation.JsonProperty;

import com.fasterxml.jackson.annotation.JsonProperty;

public class ComprasDTO {

    @JsonProperty("ID_Entrada")
    private String ID_Entrada;

    @JsonProperty("Precio_Compra")
    private String Precio_Compra; // lo manejamos como String para evitar casteos

    @JsonProperty("ID_Producto")
    private String ID_Producto;

    @JsonProperty("Documento_Empleado")
    private String Documento_Empleado;

    // Getters
    public String getID_Entrada() { return ID_Entrada; }
    public String getPrecio_Compra() { return Precio_Compra; }
    public String getID_Producto() { return ID_Producto; }
    public String getDocumento_Empleado() { return Documento_Empleado; }

    // Setters
    public void setID_Entrada(String ID_Entrada) { this.ID_Entrada = ID_Entrada; }
    public void setPrecio_Compra(String precio_Compra) { this.Precio_Compra = precio_Compra; }
    public void setID_Producto(String ID_Producto) { this.ID_Producto = ID_Producto; }
    public void setDocumento_Empleado(String documento_Empleado) { this.Documento_Empleado = documento_Empleado; }
}
