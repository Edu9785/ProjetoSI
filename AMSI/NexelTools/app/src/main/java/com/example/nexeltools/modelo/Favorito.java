package com.example.nexeltools.modelo;

import java.util.ArrayList;



public class Favorito {
    private int id, id_profile, id_produto;
    private String nome, vendedor;
    private double preco;
    private ArrayList<String> imagens;

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getVendedor() {
        return vendedor;
    }

    public void setVendedor(String vendedor) {
        this.vendedor = vendedor;
    }

    public double getPreco() {
        return preco;
    }

    public void setPreco(double preco) {
        this.preco = preco;
    }

    public ArrayList<String> getImagens() {
        return imagens;
    }

    public void setImagens(ArrayList<String> imagens) {
        this.imagens = imagens;
    }

    public Favorito(int id, int id_profile, int id_produto, double preco, String nome, String vendedor, ArrayList<String> imagens) {
        this.id = id;
        this.id_profile = id_profile;
        this.id_produto = id_produto;
        this.preco = preco;
        this.nome = nome;
        this.vendedor = vendedor;
        this.imagens = imagens;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getId_profile() {
        return id_profile;
    }

    public void setId_profile(int id_profile) {
        this.id_profile = id_profile;
    }

    public int getId_produto() {
        return id_produto;
    }

    public void setId_produto(int id_produto) {
        this.id_produto = id_produto;
    }
}
