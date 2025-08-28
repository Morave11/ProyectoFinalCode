package com.example.demo.DTO.Ventas;

import com.fasterxml.jackson.annotation.JsonProperty;

public class VentasDTO {
    @JsonProperty ("ID_Venta")
    private String ID_Venta;
    @JsonProperty("Documento_Cliente")
    private String Documento_Cliente;
    @JsonProperty("Documento_Empleado")
    private String Documento_Empleado;

    public VentasDTO() {

    }

    public String getID_Venta() {
        return this.ID_Venta;
    }

    public void setID_Venta(String ID_Venta) {
        this.ID_Venta = ID_Venta;
    }

    public String getDocumento_Empleado() {
        return this.Documento_Empleado;
    }

    public void setDocumento_Empleado(String documento_Empleado) {
        this.Documento_Empleado = documento_Empleado;
    }

    public String getDocumento_Cliente() {
        return this.Documento_Cliente;
    }

    public void setDocumento_Cliente(String documento_Cliente) {
        this.Documento_Cliente = documento_Cliente;
    }
}
