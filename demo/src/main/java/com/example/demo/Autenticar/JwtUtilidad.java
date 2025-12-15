package com.example.demo.Autenticar;

import org.springframework.stereotype.Component;
import io.jsonwebtoken.*;
import io.jsonwebtoken.security.Keys;
import org.springframework.stereotype.Component;
import java.security.Key;
import java.util.Date;
import java.security.Key;
import java.util.Date;

@Component
public class JwtUtilidad {
    private final String CLAVE_SECRETA = "EstaEsUnaClaveMuySeguraDeMasDe32Caracteres1234";
    private  final Key key = Keys.hmacShaKeyFor(CLAVE_SECRETA.getBytes());
    public String generarToken (String username){
        return  Jwts.builder()
                .setSubject(username)
                .setIssuedAt(new Date())
                .setExpiration (new Date (System.currentTimeMillis()+120000))
                .signWith(key)
                .compact();
    }
    public boolean validarToken (String token){
        try{
            Jwts.parserBuilder().setSigningKey(key).build().parseClaimsJws(token);
            return  true;
        } catch (JwtException e){
            return false;
        }
    }
}
