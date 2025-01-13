package com.example.nexeltools.modelo;

public class Profile{
    private int id, nif, telemovel;
    double avaliacao;
    String username, email, morada, nome;

    public Profile(int id, int nif, int telemovel, double avaliacao, String username, String email, String morada, String nome) {
        this.id = id;
        this.nif = nif;
        this.telemovel = telemovel;
        this.avaliacao = avaliacao;
        this.username = username;
        this.email = email;
        this.morada = morada;
        this.nome = nome;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getNif() {
        return nif;
    }

    public void setNif(int nif) {
        this.nif = nif;
    }

    public int getTelemovel() {
        return telemovel;
    }

    public void setTelemovel(int telemovel) {
        this.telemovel = telemovel;
    }

    public double getAvaliacao() {
        return avaliacao;
    }

    public void setAvaliacao(double avaliacao) {
        this.avaliacao = avaliacao;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getMorada() {
        return morada;
    }

    public void setMorada(String morada) {
        this.morada = morada;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }
}
