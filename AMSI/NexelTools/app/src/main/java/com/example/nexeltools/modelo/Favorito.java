package com.example.nexeltools.modelo;

import java.util.ArrayList;



public class Favorito {
    private int id, id_profile, id_produto;

    public Favorito(int id, int id_profile, int id_produto) {
        this.id = id;
        this.id_profile = id_profile;
        this.id_produto = id_produto;
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
