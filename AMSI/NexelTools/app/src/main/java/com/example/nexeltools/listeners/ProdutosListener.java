package com.example.nexeltools.listeners;

import com.example.nexeltools.modelo.Produto;

import java.util.ArrayList;

public interface ProdutosListener {
    void onProdutosFetched(ArrayList<Produto> produtos);
}
