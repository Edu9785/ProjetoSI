package com.example.nexeltools;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.text.TextWatcher;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.SeekBar;
import android.widget.TextView;
import android.widget.Toast;

import com.example.nexeltools.adaptadores.produtosAdapter;
import com.example.nexeltools.listeners.FavoritosListener;
import com.example.nexeltools.listeners.ProdutosListener;
import com.example.nexeltools.modelo.Produto;
import com.example.nexeltools.modelo.singletonAPI;

import java.util.ArrayList;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link produtosFragment#newInstance} factory method to
 * create an instance of this fragment.
 */
public class produtosFragment extends Fragment implements ProdutosListener{

    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    ListView listViewProdutos;
    ArrayList<Produto> produtos;
    produtosAdapter produtosAdapter;
    private SeekBar filtrarPreco;
    private TextView precoMax;
    private EditText Pesquisa;

    public produtosFragment() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment produtosFragment.
     */
    // TODO: Rename and change types and number of parameters
    public static produtosFragment newInstance(String param1, String param2) {
        produtosFragment fragment = new produtosFragment();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_produtos, container, false);
        listViewProdutos = view.findViewById(R.id.listViewProdutos);
        produtos = new ArrayList<>();
        produtosAdapter = new produtosAdapter(getContext(), produtos);
        listViewProdutos.setAdapter(produtosAdapter);
        filtrarPreco = view.findViewById(R.id.filtrarPreco);
        precoMax = view.findViewById(R.id.precoMax);
        Pesquisa = view.findViewById(R.id.Pesquisa);

        singletonAPI.getInstance(getContext()).setProdutosListener(this);
        singletonAPI.getInstance(getContext()).getAllProdutosApi(getContext());

        filtrarPreco.setMax(15000);
        filtrarPreco.setProgress(15000);
        precoMax.setText(15000+"");

        filtrarPreco.setOnSeekBarChangeListener(new SeekBar.OnSeekBarChangeListener() {
            @Override
            public void onProgressChanged(SeekBar seekBar, int progress, boolean fromUser) {

            }

            @Override
            public void onStartTrackingTouch(SeekBar seekBar) {}

            @Override
            public void onStopTrackingTouch(SeekBar seekBar) {}
        });



        return view;
    }


    @Override
    public void onRefreshListaProdutos(ArrayList<Produto> produtosCatalogo) {
        if(produtosCatalogo != null){
            listViewProdutos.setAdapter(new produtosAdapter(getContext(), produtosCatalogo));
        }
    }

    @Override
    public void onAddFavoritoSuccess() {
        Toast.makeText(getContext(), "Produto adicionado aos favoritos!", Toast.LENGTH_SHORT).show();
    }
}