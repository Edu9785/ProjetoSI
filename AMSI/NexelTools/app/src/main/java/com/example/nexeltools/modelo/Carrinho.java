package com.example.nexeltools.modelo;

import java.util.ArrayList;

public class Carrinho {

    private int id;
    private int id_profile;
    private ArrayList<Produto> produtos;
    private double precototal;

    public Carrinho(int id, int id_profile, ArrayList<Produto> produtos, double precototal) {
        this.id = id;
        this.id_profile = id_profile;
        this.produtos = produtos;
        this.precototal = precototal;
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

    public ArrayList<Produto> getProdutos() {
        return produtos;
    }

    public void setProdutos(ArrayList<Produto> produtos) {
        this.produtos = produtos;
    }

    public double getPrecototal() {
        return precototal;
    }

    public void setPrecototal(double precototal) {
        this.precototal = precototal;
    }
}

