package com.example.nexeltools.modelo;

import java.io.Serializable;
import java.time.LocalDateTime;
import java.util.ArrayList;

public class Produto implements Serializable {

    private int id, id_tipo, estado, id_vendedor;
    private String desc, nome, vendedor;
    private double preco, avaliacao;
    private ArrayList<String> imagens;

    public Produto(int id, String desc, double preco, String nome, String vendedor, int estado, int id_vendedor, int id_tipo, ArrayList<String> imagens, double avaliacao) {
        this.id = id;
        this.desc = desc;
        this.preco = preco;
        this.nome = nome;
        this.vendedor = vendedor;
        this.id_tipo = id_tipo;
        this.estado = estado;
        this.imagens = imagens;
        this.avaliacao = avaliacao;
        this.id_vendedor = id_vendedor;
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

    public double getAvaliacao() {
        return avaliacao;
    }

    public void setAvaliacao(double avaliacao) {
        this.avaliacao = avaliacao;
    }

    public int getId_vendedor() {
        return id_vendedor;
    }

    public void setId_vendedor(int id_vendedor) {
        this.id_vendedor = id_vendedor;
    }

}

