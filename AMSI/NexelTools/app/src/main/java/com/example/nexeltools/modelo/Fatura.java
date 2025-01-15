package com.example.nexeltools.modelo;

import java.util.ArrayList;

public class Fatura {

    int id;
    ArrayList<Produto> linhasfatura;
    Double precofatura, expedicaopreco;
    String datahora, comprador, expedicaonome;

    public Fatura(int id, ArrayList<Produto> linhasfatura, Double precofatura, Double expedicaopreco, String datahora, String comprador, String expedicaonome) {
        this.id = id;
        this.linhasfatura = linhasfatura;
        this.precofatura = precofatura;
        this.expedicaopreco = expedicaopreco;
        this.datahora = datahora;
        this.comprador = comprador;
        this.expedicaonome = expedicaonome;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public ArrayList<Produto> getLinhasfatura() {
        return linhasfatura;
    }

    public void setLinhasfatura(ArrayList<Produto> linhasfatura) {
        this.linhasfatura = linhasfatura;
    }

    public Double getPrecofatura() {
        return precofatura;
    }

    public void setPrecofatura(Double precofatura) {
        this.precofatura = precofatura;
    }

    public Double getExpedicaopreco() {
        return expedicaopreco;
    }

    public void setExpedicaopreco(Double expedicaopreco) {
        this.expedicaopreco = expedicaopreco;
    }

    public String getDatahora() {
        return datahora;
    }

    public void setDatahora(String datahora) {
        this.datahora = datahora;
    }

    public String getComprador() {
        return comprador;
    }

    public void setComprador(String comprador) {
        this.comprador = comprador;
    }

    public String getExpedicaonome() {
        return expedicaonome;
    }

    public void setExpedicaonome(String expedicaonome) {
        this.expedicaonome = expedicaonome;
    }
}
