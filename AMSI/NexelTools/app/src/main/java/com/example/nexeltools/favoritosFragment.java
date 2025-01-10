package com.example.nexeltools;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.Toast;

import com.example.nexeltools.adaptadores.favoritosAdapter;
import com.example.nexeltools.adaptadores.produtosAdapter;
import com.example.nexeltools.listeners.FavoritosListener;
import com.example.nexeltools.listeners.ProdutosListener;
import com.example.nexeltools.modelo.Favorito;
import com.example.nexeltools.modelo.Produto;
import com.example.nexeltools.modelo.singletonAPI;

import java.util.ArrayList;

public class favoritosFragment extends Fragment implements FavoritosListener {

    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    private ListView listViewFavoritos;
    private ArrayList<Favorito> favoritos;
    private favoritosAdapter favoritosAdapter;

    public favoritosFragment() {

    }

    public static favoritosFragment newInstance(String param1, String param2) {
        favoritosFragment fragment = new favoritosFragment();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_favoritos, container, false);
        listViewFavoritos = view.findViewById(R.id.listViewFav);
        favoritos = new ArrayList<>();
        favoritosAdapter = new favoritosAdapter(getContext(), favoritos);
        listViewFavoritos.setAdapter(favoritosAdapter);

        singletonAPI.getInstance(getContext()).setFavoritosListener(this);
        singletonAPI.getInstance(getContext()).getAllFavoritosApi(getContext());

        return view;
    }

    @Override
    public void onRefreshListaFavoritos(ArrayList<Favorito> favoritos) {
        if(favoritos != null){
            listViewFavoritos.setAdapter(new favoritosAdapter(getContext(), favoritos));
        }
    }

    @Override
    public void onRemoveFavoritoSuccess() {
        Toast.makeText(getContext(), "Produto removido dos favoritos", Toast.LENGTH_SHORT).show();
        singletonAPI.getInstance(getContext()).getAllFavoritosApi(getContext());
    }

}