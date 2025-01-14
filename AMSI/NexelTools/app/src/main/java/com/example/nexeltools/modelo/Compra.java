package com.example.nexeltools.modelo;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

public class Compra {
    int id, id_profile;
    double precototal;
    String metodoexpedicao, metodopagamento, datacompra;

    public Compra(int id, double precototal, String metodoexpedicao, String metodopagamento, String datacompra, int id_profile) {
        this.id = id;
        this.precototal = precototal;
        this.metodoexpedicao = metodoexpedicao;
        this.metodopagamento = metodopagamento;
        this.datacompra = datacompra;
        this.id_profile = id_profile;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public double getPrecototal() {
        return precototal;
    }

    public void setPrecototal(double precototal) {
        this.precototal = precototal;
    }

    public String getMetodoexpedicao() {
        return metodoexpedicao;
    }

    public void setMetodoexpedicao(String metodoexpedicao) {
        this.metodoexpedicao = metodoexpedicao;
    }

    public String getMetodopagamento() {
        return metodopagamento;
    }

    public void setMetodopagamento(String metodopagamento) {
        this.metodopagamento = metodopagamento;
    }

    public String getDatacompra() {
        return datacompra;
    }

    public void setDatacompra(String datacompra) {
        this.datacompra = datacompra;
    }

    public int getId_profile() {
        return id_profile;
    }

    public void setId_profile(int id_profile) {
        this.id_profile = id_profile;
    }
}
