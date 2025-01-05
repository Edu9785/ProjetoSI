package com.example.nexeltools.modelo;

import java.time.LocalDateTime;

public class Produto {

    private int id, id_tipo, id_vendedor, estado;
    private String desc, nome;
    private double preco;
    private LocalDateTime data_criacao;

    public Produto(int id, String desc, double preco, String nome, int id_vendedor) {
        this.id = id;
        this.desc = desc;
        this.preco = preco;
        this.nome = nome;
        this.id_vendedor = id_vendedor;
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

    public int getId_vendedor() {
        return id_vendedor;
    }

    public int getEstado() {
        return estado;
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

    public void setEstado(int estado) {
        this.estado = estado;
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
        this.id_vendedor = id_vendedor;
    }

    public void setPreco(double preco) {
        this.preco = preco;
    }

}

