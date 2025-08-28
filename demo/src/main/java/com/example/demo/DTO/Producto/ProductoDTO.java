package com.example.demo.DTO.Producto;

import com.fasterxml.jackson.annotation.JsonProperty;

public class ProductoDTO {

    @JsonProperty("ID_Producto")
    private String ID_Producto;

    @JsonProperty("Nombre_Producto")
    private String Nombre_Producto;

    @JsonProperty("Descripcion")
    private String Descripcion;

    @JsonProperty("Precio_Venta")
    private String precio_Venta;   // sugerido BigDecimal en proyectos grandes

    @JsonProperty("Stock_Minimo")
    private String stock_Minimo;   // sugerido Integer en proyectos grandes

    @JsonProperty("ID_Categoria")
    private String ID_Categoria;

    @JsonProperty("ID_Estado")
    private String ID_Estado;

    @JsonProperty("ID_Gama")
    private String ID_Gama;

    public ProductoDTO() {}

    // Getters
    public String getID_Producto()   { return this.ID_Producto; }
    public String getNombre_Producto(){ return this.Nombre_Producto; }
    public String getDescripcion()   { return this.Descripcion; }
    public String getPrecio_Venta()  { return this.precio_Venta; }
    public String getStock_Minimo()  { return this.stock_Minimo; }
    public String getID_Categoria()  { return this.ID_Categoria; }
    public String getID_Estado()     { return this.ID_Estado; }
    public String getID_Gama()       { return this.ID_Gama; }

    // Setters
    public void setID_Producto(String ID_Producto)         { this.ID_Producto = ID_Producto; }
    public void setNombre_Producto(String nombre_Producto) { this.Nombre_Producto = nombre_Producto; }
    public void setDescripcion(String descripcion)         { this.Descripcion = descripcion; }
    public void setPrecio_Venta(String precio_Venta)       { this.precio_Venta = precio_Venta; }
    public void setStock_Minimo(String stock_Minimo)       { this.stock_Minimo = stock_Minimo; }
    public void setID_Categoria(String ID_Categoria)       { this.ID_Categoria = ID_Categoria; }
    public void setID_Estado(String ID_Estado)             { this.ID_Estado = ID_Estado; }
    public void setID_Gama(String ID_Gama)                 { this.ID_Gama = ID_Gama; }
}