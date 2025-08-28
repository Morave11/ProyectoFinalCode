package com.example.demo.DTO.DetalleVentas;

import com.fasterxml.jackson.annotation.JsonProperty;

public class DetalleVentasDTO {
    @JsonProperty ("Cantidad")
    private String Cantidad;
    @JsonProperty("Fecha_Salida")
    private String Fecha_Salida;
    @JsonProperty("ID_Proveedor")
    private String ID_Proveedor;
    @JsonProperty("ID_Entrada")
    private String ID_Entrada;

    public DetalleVentasDTO(){
    }

    public String getCantidad() {
        return this.Cantidad;
    }

    public void setCantidad(String cantidad) {
        this.Cantidad = cantidad;
    }

    public String getFecha_Salida() {
        return this.Fecha_Salida;
    }

    public void setFecha_Salida(String fecha_Salida) {
        this.Fecha_Salida = fecha_Salida;
    }

    public String getID_Proveedor() {
        return this.ID_Proveedor;
    }

    public void setID_Proveedor(String ID_Proveedor) {
        this.ID_Proveedor = ID_Proveedor;
    }

    public String getID_Entrada() {
        return ID_Entrada;
    }

    public void setID_Entrada(String ID_Entrada) {
        this.ID_Entrada = ID_Entrada;
    }
}
