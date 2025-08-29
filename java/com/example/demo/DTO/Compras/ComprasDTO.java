package com.example.demo.DTO.Compras;

import com.fasterxml.jackson.annotation.JsonProperty;

public class ComprasDTO {
    @JsonProperty("ID_Entrada")
    private String ID_Entrada;
    @JsonProperty("Precio_Compra")
    private Double Precio_Compra;
    @JsonProperty("ID_Producto")
    private String ID_Producto;

    public  ComprasDTO(){
    }

    public String getDocumento_EMpleado() {
        return this.Documento_EMpleado;
    }

    public void setDocumento_EMpleado(String documento_EMpleado) {
        this.Documento_EMpleado = documento_EMpleado;
    }

    public String getID_Entrada() {
        return this.ID_Entrada;
    }

    public void setID_Entrada(String ID_Entrada) {
        this.ID_Entrada = ID_Entrada;
    }

    public Double getPrecio_Compra() {
        return this.Precio_Compra;
    }

    public void setPrecio_Compra(Double precio_Compra) {
        this.Precio_Compra = precio_Compra;
    }

    public String getID_Producto() {
        return this.ID_Producto;
    }

    public void setID_Producto(String ID_Producto) {
        this.ID_Producto = ID_Producto;
    }

    private String Documento_EMpleado;
}
