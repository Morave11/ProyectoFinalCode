package com.example.demo.DTO.Producto;

import com.fasterxml.jackson.annotation.JsonInclude;
import com.fasterxml.jackson.annotation.JsonProperty;

@JsonInclude(JsonInclude.Include.NON_NULL)
public class ProductoDTO {

    // 🔹 AUTO_INCREMENT → no obligatorio al crear
    @JsonProperty("ID_Producto")
    private Integer ID_Producto;

    @JsonProperty("Nombre_Producto")
    private String Nombre_Producto;

    @JsonProperty("Descripcion")
    private String Descripcion;

    // 🔹 NUMÉRICOS en BD
    @JsonProperty("Precio_Venta")
    private Double Precio_Venta;

    @JsonProperty("Stock_Minimo")
    private Integer Stock_Minimo;

    // 🔹 FKs INT en BD
    @JsonProperty("ID_Categoria")
    private Integer ID_Categoria;

    @JsonProperty("ID_Estado")
    private Integer ID_Estado;

    @JsonProperty("ID_Gama")
    private Integer ID_Gama;

    // 🔹 Base64 o URL
    @JsonProperty("Fotos")
    private String Fotos;

    public ProductoDTO() {}

    // ================= GETTERS =================

    public Integer getID_Producto() {
        return ID_Producto;
    }

    public String getNombre_Producto() {
        return Nombre_Producto;
    }

    public String getDescripcion() {
        return Descripcion;
    }

    public Double getPrecio_Venta() {
        return Precio_Venta;
    }

    public Integer getStock_Minimo() {
        return Stock_Minimo;
    }

    public Integer getID_Categoria() {
        return ID_Categoria;
    }

    public Integer getID_Estado() {
        return ID_Estado;
    }

    public Integer getID_Gama() {
        return ID_Gama;
    }

    public String getFotos() {
        return Fotos;
    }

    // ================= SETTERS =================

    public void setID_Producto(Integer ID_Producto) {
        this.ID_Producto = ID_Producto;
    }

    public void setNombre_Producto(String nombre_Producto) {
        Nombre_Producto = nombre_Producto;
    }

    public void setDescripcion(String descripcion) {
        Descripcion = descripcion;
    }

    public void setPrecio_Venta(Double precio_Venta) {
        Precio_Venta = precio_Venta;
    }

    public void setStock_Minimo(Integer stock_Minimo) {
        Stock_Minimo = stock_Minimo;
    }

    public void setID_Categoria(Integer ID_Categoria) {
        this.ID_Categoria = ID_Categoria;
    }

    public void setID_Estado(Integer ID_Estado) {
        this.ID_Estado = ID_Estado;
    }

    public void setID_Gama(Integer ID_Gama) {
        this.ID_Gama = ID_Gama;
    }

    public void setFotos(String fotos) {
        Fotos = fotos;
    }
}
