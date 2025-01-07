package com.example.nexeltools.modelo;

import java.time.LocalDateTime;
import java.util.ArrayList;

public class Produto {

    private int id, id_tipo, estado;
    private String desc, nome, vendedor;
    private double preco;
    private ArrayList<String> imagens;

    public Produto(int id, String desc, double preco, String nome, String vendedor, int estado, int id_tipo, ArrayList<String> imagens) {
        this.id = id;
        this.desc = desc;
        this.preco = preco;
        this.nome = nome;
        this.vendedor = vendedor;
        this.id_tipo = id_tipo;
        this.estado = estado;
        this.imagens = imagens;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getId_tipo() {
        return id_tipo;
    }

    public void setId_tipo(int id_tipo) {
        this.id_tipo = id_tipo;
    }

    public int getEstado() {
        return estado;
    }

    public void setEstado(int estado) {
        this.estado = estado;
    }

    public String getVendedor() {
        return vendedor;
    }

    public void setVendedor(String vendedor) {
        this.vendedor = vendedor;
    }

    public String getDesc() {
        return desc;
    }

    public void setDesc(String desc) {
        this.desc = desc;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
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

}

