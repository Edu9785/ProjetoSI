package com.example.nexeltools.listeners;

import com.example.nexeltools.modelo.Avaliacao;
import com.example.nexeltools.modelo.Produto;

import java.util.ArrayList;

public interface ProdutoListener {

    void detalhesProduto(Produto produto);
    void onRefreshListaAvaliacao(ArrayList<Avaliacao> avaliacoes);

}
