package com.example.nexeltools.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import com.example.nexeltools.R;
import com.example.nexeltools.modelo.Produto;

import java.util.ArrayList;

public class produtosAdapter extends ArrayAdapter<Produto> {

    public produtosAdapter(Context context, ArrayList<Produto> produtos) {
        super(context, 0, produtos);
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (convertView == null) {
            convertView = LayoutInflater.from(getContext()).inflate(R.layout.item_produto, parent, false);
        }

        Produto produto = getItem(position);

        TextView tvNome = convertView.findViewById(R.id.txtProduto);
        TextView tvPreco = convertView.findViewById(R.id.txtPreco);
        TextView tvVendedor = convertView.findViewById(R.id.txtVendedor);

        tvNome.setText(produto.getNome().toString());
        tvPreco.setText(String.format("R$ %.2f", produto.getPreco()));
        tvVendedor.setText(produto.getId_vendedor());

        return convertView;
    }
}

