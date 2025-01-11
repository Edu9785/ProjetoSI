package com.example.nexeltools;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.example.nexeltools.adaptadores.carrinhoAdapter;
import com.example.nexeltools.adaptadores.favoritosAdapter;
import com.example.nexeltools.listeners.CarrinhoListener;
import com.example.nexeltools.modelo.Carrinho;
import com.example.nexeltools.modelo.Favorito;
import com.example.nexeltools.modelo.Produto;
import com.example.nexeltools.modelo.singletonAPI;

import java.util.ArrayList;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link carrinhoFragment#newInstance} factory method to
 * create an instance of this fragment.
 */
public class carrinhoFragment extends Fragment implements CarrinhoListener {

    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    private ListView listViewCart;
    private TextView txtPrecoTotal;
    private ArrayList<Produto> produtos;
    private carrinhoAdapter carrinhoAdapter;
    private Carrinho carrinho;

    public carrinhoFragment() {

    }


    public static carrinhoFragment newInstance(String param1, String param2) {
        carrinhoFragment fragment = new carrinhoFragment();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_carrinho, container, false);


        listViewCart = view.findViewById(R.id.listViewCart);
        txtPrecoTotal = view.findViewById(R.id.txtPrecoTotal);
        produtos = new ArrayList<>();
        Carrinho carrinhoVazio = new Carrinho(0, 0, new ArrayList<>(), 0.0);
        carrinhoAdapter = new carrinhoAdapter(getContext(), carrinhoVazio);
        listViewCart.setAdapter(carrinhoAdapter);

        singletonAPI.getInstance(getContext()).setCarrinhoListener(this);
        singletonAPI.getInstance(getContext()).getCarrinho(getContext());

        return view;
    }

    @Override
    public void onRefreshListaCarrinho(Carrinho carrinho) {
        produtos = carrinho.getProdutos();
        listViewCart.setAdapter(new carrinhoAdapter(getContext(), carrinho));
        txtPrecoTotal.setText(carrinho.getPrecototal() + "€");
    }

    @Override
    public void removerCarrinhoSuccess() {
        Toast.makeText(getContext(), "Produto removido do carrinho!", Toast.LENGTH_SHORT).show();
        singletonAPI.getInstance(getContext()).getCarrinho(getContext());
    }
}