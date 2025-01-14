package com.example.nexeltools.listeners;

import com.example.nexeltools.modelo.Compra;
import com.example.nexeltools.modelo.Produto;

import java.util.ArrayList;

public interface HistoricoListener {

    void onRefreshListaCompras(ArrayList<Compra> compras);
    void onRefreshListaVendas(ArrayList<Produto> vendas);
}
