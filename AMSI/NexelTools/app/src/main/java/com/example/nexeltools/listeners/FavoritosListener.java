package com.example.nexeltools.listeners;

import com.example.nexeltools.modelo.Favorito;
import com.example.nexeltools.modelo.Produto;

import java.util.ArrayList;

public interface FavoritosListener {

    void onRefreshListaFavoritos(ArrayList<Favorito> favoritos);

    void onRemoveFavoritoSuccess();

    void onAddCarrinhoSuccess(String message);
}
