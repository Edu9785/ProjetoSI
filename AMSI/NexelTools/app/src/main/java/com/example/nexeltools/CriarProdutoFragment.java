package com.example.nexeltools;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Spinner;
import android.widget.Toast;

import com.example.nexeltools.listeners.CategoriaListener;
import com.example.nexeltools.modelo.Categoria;
import com.example.nexeltools.modelo.SingletonAPI;

import java.util.ArrayList;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link CriarProdutoFragment#newInstance} factory method to
 * create an instance of this fragment.
 */
public class CriarProdutoFragment extends Fragment implements CategoriaListener {

    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";
    private Spinner spinnerCategorias;



    public CriarProdutoFragment() {

    }


    public static CriarProdutoFragment newInstance(String param1, String param2) {
        CriarProdutoFragment fragment = new CriarProdutoFragment();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_criar_produto, container, false);

        spinnerCategorias = view.findViewById(R.id.spinnerCategorias);

        SingletonAPI.getInstance(getContext()).setCategoriaListener(this);
        SingletonAPI.getInstance(getContext()).getCategoriasApi(getContext());

        return view;
    }

    @Override
    public void LoadCategorias(ArrayList<Categoria> categorias) {
        if (categorias != null && !categorias.isEmpty()) {

            ArrayAdapter<Categoria> adapter = new ArrayAdapter<>(
                    getContext(),
                    android.R.layout.simple_spinner_item,
                    categorias
            );
            adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

            spinnerCategorias.setAdapter(adapter);
        } else {
            Toast.makeText(getContext(), "Nenhuma categoria encontrada.", Toast.LENGTH_SHORT).show();
        }
    }
}