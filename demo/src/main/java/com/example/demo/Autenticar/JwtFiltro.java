package com.example.demo.Autenticar;
import jakarta.servlet.FilterChain;
import jakarta.servlet.ServletException;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;
import org.springframework.web.filter.OncePerRequestFilter;

import java.io.IOException;

@Component
public class JwtFiltro extends OncePerRequestFilter {
    @Autowired
    private JwtUtilidad jwtUtil;
    @Override
    protected void doFilterInternal(HttpServletRequest solicitud,
                                    HttpServletResponse respuesta,
                                    FilterChain cadenaFiltro)
            throws ServletException, IOException {

        String authHeader = solicitud.getHeader("Authorization");

        if (authHeader != null && authHeader.startsWith("Bearer ")) {
            String token = authHeader.substring(7);

            if (!jwtUtil.validarToken(token)) {
                respuesta.setStatus(HttpServletResponse.SC_UNAUTHORIZED);
                return;
            }
        } else {
            respuesta.setStatus(HttpServletResponse.SC_UNAUTHORIZED);
            return;
        }

        cadenaFiltro.doFilter(solicitud, respuesta);
    }
    @Override
    protected boolean shouldNotFilter(HttpServletRequest solicitud) {
        String path =  solicitud.getRequestURI();
        return path.startsWith("/auth");
    }
}