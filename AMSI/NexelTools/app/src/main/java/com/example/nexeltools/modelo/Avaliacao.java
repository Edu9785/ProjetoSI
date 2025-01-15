package com.example.nexeltools.modelo;

public class Avaliacao {
    int id;
    double avaliacao;
    String comentario, username;

    public Avaliacao(int id, double avaliacao, String comentario, String username) {
        this.id = id;
        this.avaliacao = avaliacao;
        this.comentario = comentario;
        this.username = username;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public double getAvaliacao() {
        return avaliacao;
    }

    public void setAvaliacao(double avaliacao) {
        this.avaliacao = avaliacao;
    }

    public String getComentario() {
        return comentario;
    }

    public void setComentario(String comentario) {
        this.comentario = comentario;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }
}
