package com.example.demo.DTO.DetalleVentas;

import com.fasterxml.jackson.annotation.JsonProperty;

public class DetalleVentasDTO {

    @JsonProperty("Cantidad")
    private int Cantidad;

    @JsonProperty("Fecha_Salida")
    private String Fecha_Salida; // formato YYYY-MM-DD

    @JsonProperty("ID_Producto")
    private String ID_Producto;

    @JsonProperty("ID_Venta")
    private String ID_Venta;

    public DetalleVentasDTO() {}

    // Getters
    public int getCantidad() { return Cantidad; }
    public String getFecha_Salida() { return Fecha_Salida; }
    public String getID_Producto() { return ID_Producto; }
    public String getID_Venta() { return ID_Venta; }

    // Setters
    public void setCantidad(int cantidad) { this.Cantidad = cantidad; }
    public void setFecha_Salida(String fecha_Salida) { this.Fecha_Salida = fecha_Salida; }
    public void setID_Producto(String ID_Producto) { this.ID_Producto = ID_Producto; }
    public void setID_Venta(String ID_Venta) { this.ID_Venta = ID_Venta; }
}