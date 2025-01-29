package com.example.nexeltools.modelo;

import androidx.annotation.NonNull;

public class Metodoexpedicao {
    int id;
    String nome;
    double preco;

    public Metodoexpedicao(int id, String nome, double preco) {
        this.id = id;
        this.nome = nome;
        this.preco = preco;
    }

    public int getId() {
        return id;
    }

    public String getNome() {
        return nome;
    }

    public double getPreco(){
        return preco;
    }

    @NonNull
    @Override
    public String toString() {
        return getNome() + " " + getPreco()+" €";
    }
}