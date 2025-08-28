package com.example.demo.DTO.DetalleDevolucion;

import com.fasterxml.jackson.annotation.JsonProperty;

public class DetalleDevolucionesDTO {
    @JsonProperty("ID_Devolucion")
    private String ID_Devolucion;
    @JsonProperty("Cantidad_Devuelta")
    private int Cantidad_Devuelta;
    @JsonProperty("ID_Venta")
    private String ID_Venta;

    public  DetalleDevolucionesDTO(){
    }

    public String getID_Devolucion() {
        return this.ID_Devolucion;
    }

    public void setID_Devolucion(String ID_Devolucion) {
        this.ID_Devolucion = ID_Devolucion;
    }

    public int getCantidad_Devuelta() {
        return this.Cantidad_Devuelta;
    }

    public void setCantidad_Devuelta(int cantidad_Devuelta) {
        this.Cantidad_Devuelta = cantidad_Devuelta;
    }

    public String getID_Venta() {
        return this.ID_Venta;
    }

    public void setID_Venta(String ID_Venta) {
        this.ID_Venta = ID_Venta;
    }
}
