package com.example.nexeltools.listeners;

import com.example.nexeltools.modelo.Carrinho;

public interface CarrinhoListener {
    void onRefreshListaCarrinho(Carrinho carrinho);

    void removerCarrinhoSuccess();
}
