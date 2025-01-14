package com.example.nexeltools.modelo;

import androidx.annotation.NonNull;

public class Metodopagamento {
    int id;
    String nome;


    public Metodopagamento(int id, String nome) {
        this.id = id;
        this.nome = nome;
    }

    public int getId() {
        return id;
    }

    public String getNome() {
        return nome;
    }


    @NonNull
    @Override
    public String toString() {
        return getNome();
    }
}