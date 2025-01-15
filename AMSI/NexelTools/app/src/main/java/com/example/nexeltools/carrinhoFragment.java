package com.example.nexeltools;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.example.nexeltools.adaptadores.CarrinhoAdapter;
import com.example.nexeltools.listeners.CarrinhoListener;
import com.example.nexeltools.modelo.Carrinho;
import com.example.nexeltools.modelo.Produto;
import com.example.nexeltools.modelo.SingletonAPI;

import java.util.ArrayList;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link CarrinhoFragment#newInstance} factory method to
 * create an instance of this fragment.
 */
public class CarrinhoFragment extends Fragment implements CarrinhoListener {

    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    private ListView listViewCart;
    private TextView txtPrecoTotal;
    private ArrayList<Produto> produtos;
    private CarrinhoAdapter carrinhoAdapter;
    private Carrinho carrinho;
    private double totalcarrinho;
    private Button btnCheckout;

    public CarrinhoFragment() {

    }


    public static CarrinhoFragment newInstance(String param1, String param2) {
        CarrinhoFragment fragment = new CarrinhoFragment();
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
        carrinhoAdapter = new CarrinhoAdapter(getContext(), carrinhoVazio);
        listViewCart.setAdapter(carrinhoAdapter);
        btnCheckout = view.findViewById(R.id.btnCheckout);

        SingletonAPI.getInstance(getContext()).setCarrinhoListener(this);
        SingletonAPI.getInstance(getContext()).getCarrinho(getContext());

        btnCheckout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(view.getContext(), CheckoutActivity.class);
                intent.putExtra("totalcarrinho", totalcarrinho);
                startActivity(intent);
            }
        });

        return view;
    }

    @Override
    public void onRefreshListaCarrinho(Carrinho carrinho) {
        produtos = carrinho.getProdutos();
        listViewCart.setAdapter(new CarrinhoAdapter(getContext(), carrinho));
        totalcarrinho = carrinho.getPrecototal();
        txtPrecoTotal.setText(carrinho.getPrecototal() + "€");
    }

    @Override
    public void removerCarrinhoSuccess() {
        Toast.makeText(getContext(), "Produto removido do carrinho!", Toast.LENGTH_SHORT).show();
        SingletonAPI.getInstance(getContext()).getCarrinho(getContext());
    }
}