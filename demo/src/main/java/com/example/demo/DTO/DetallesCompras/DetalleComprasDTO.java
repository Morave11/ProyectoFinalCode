package com.example.demo.DTO.DetallesCompras;

import com.fasterxml.jackson.annotation.JsonProperty;

import java.util.Date;

public class DetalleComprasDTO {
    @JsonProperty("Fecha_Entrada")
    private Date Fecha_Entrada;
    @JsonProperty("Cantidad")
    private  String Cantidad;
    @JsonProperty("ID_Proveedor")
    private  String ID_Proveedor;
    @JsonProperty("ID_Entrada")
    private  String ID_Entrada;

    public DetalleComprasDTO(){
    }

    public Date getFecha_Entrada() {
        return this.Fecha_Entrada;
    }

    public void setFecha_Entrada(Date fecha_Entrada) {
        this.Fecha_Entrada = fecha_Entrada;
    }

    public String getCantidad() {
        return this.Cantidad;
    }

    public void setCantidad(String cantidad) {
        this.Cantidad = cantidad;
    }

    public String getID_Proveedor() {
        return this.ID_Proveedor;
    }

    public void setID_Proveedor(String ID_Proveedor) {
        this.ID_Proveedor = ID_Proveedor;
    }

    public String getID_Entrada() {
        return this.ID_Entrada;
    }

    public void setID_Entrada(String ID_Entrada) {
        this.ID_Entrada = ID_Entrada;
    }
}
