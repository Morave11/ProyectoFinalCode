package com.example.demo.Autenticar;
import org.springframework.boot.web.servlet.FilterRegistrationBean;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;

@Configuration
public class FiltroConfig {

    @Bean
    public FilterRegistrationBean<JwtFiltro> JWTfiltro(JwtFiltro filtro) {
        FilterRegistrationBean<JwtFiltro> registroFiltro = new FilterRegistrationBean<>();
        registroFiltro.setFilter(filtro);
        registroFiltro.addUrlPatterns("/Productos/*");
        return registroFiltro;
    }
}