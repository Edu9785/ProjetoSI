package com.example.nexeltools.modelo;

import java.time.LocalDateTime;
import java.util.ArrayList;

public class Produto {

    private int id, id_tipo;
    private String desc, nome, vendedor;
    private double preco;
    private LocalDateTime data_criacao;
    private ArrayList<String> imagens;

    public Produto(int id, String desc, double preco, String nome, String vendedor) {
        this.id = id;
        this.desc = desc;
        this.preco = preco;
        this.nome = nome;
        this.vendedor = vendedor;
        this.imagens = imagens;
    }

    public ArrayList<String> getImagens() {
        return imagens;
    }

    public void setImagens(ArrayList<String> imagens) {
        this.imagens = imagens;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getNome() {
        return nome;
    }

    public int getId() {
        return id;
    }

    public int getId_tipo() {
        return id_tipo;
    }

    public String getvendedor() {
        return vendedor;
    }


    public String getDesc() {
        return desc;
    }

    public double getPreco() {
        return preco;
    }

    public LocalDateTime getData_criacao() {
        return data_criacao;
    }

    public void setData_criacao(LocalDateTime data_criacao) {
        this.data_criacao = data_criacao;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setDesc(String desc) {
        this.desc = desc;
    }

    public void setId_tipo(int id_tipo) {
        this.id_tipo = id_tipo;
    }

    public void setId_vendedor(int id_vendedor) {
        this.vendedor = vendedor;
    }

    public void setPreco(double preco) {
        this.preco = preco;
    }

}

