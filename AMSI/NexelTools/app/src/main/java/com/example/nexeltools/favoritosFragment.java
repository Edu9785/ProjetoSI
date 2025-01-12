package com.example.nexeltools;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.Toast;

import com.example.nexeltools.adaptadores.FavoritosAdapter;
import com.example.nexeltools.listeners.FavoritosListener;
import com.example.nexeltools.modelo.Favorito;
import com.example.nexeltools.modelo.SingletonAPI;

import java.util.ArrayList;

public class FavoritosFragment extends Fragment implements FavoritosListener {

    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    private ListView listViewFavoritos;
    private ArrayList<Favorito> favoritos;
    private FavoritosAdapter favoritosAdapter;

    public FavoritosFragment() {

    }

    public static FavoritosFragment newInstance(String param1, String param2) {
        FavoritosFragment fragment = new FavoritosFragment();
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
        favoritosAdapter = new FavoritosAdapter(getContext(), favoritos);
        listViewFavoritos.setAdapter(favoritosAdapter);

        SingletonAPI.getInstance(getContext()).setFavoritosListener(this);
        SingletonAPI.getInstance(getContext()).getAllFavoritosApi(getContext());

        return view;
    }

    @Override
    public void onRefreshListaFavoritos(ArrayList<Favorito> favoritos) {
        if(favoritos != null){
            listViewFavoritos.setAdapter(new FavoritosAdapter(getContext(), favoritos));
        }
    }

    @Override
    public void onRemoveFavoritoSuccess() {
        Toast.makeText(getContext(), "Produto removido dos favoritos", Toast.LENGTH_SHORT).show();
        SingletonAPI.getInstance(getContext()).getAllFavoritosApi(getContext());
    }

    @Override
    public void onAddCarrinhoSuccess(String message) {
        Toast.makeText(getContext(), message, Toast.LENGTH_SHORT).show();
    }

}