package com.example.nexeltools.listeners;

import com.example.nexeltools.modelo.Produto;
import com.example.nexeltools.modelo.Profile;

import java.util.ArrayList;

public interface ProfileListener {

    void onLoadProfile(Profile profile);
    void onRefreshListaProdutosVendedor(ArrayList<Produto> produtosvendedor);
    void onDeleteProductSuccess();
}
