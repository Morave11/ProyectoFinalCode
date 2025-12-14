package com.example.demo.Autenticar;

public class LoginResponse {
    private String token;
    private String rol;

    // ✅ Constructor vacío (necesario para Jackson)
    public LoginResponse() {
    }

    public LoginResponse(String token, String rol) {
        this.token = token;
        this.rol = rol;
    }

    public String getToken() { return token; }
    public String getRol() { return rol; }

    // ✅ (Opcional, recomendado)
    public void setToken(String token) { this.token = token; }
    public void setRol(String rol) { this.rol = rol; }
}
