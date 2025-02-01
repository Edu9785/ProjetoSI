package com.example.nexeltools.adaptadores;

import android.content.Context;
import android.content.SharedPreferences;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.nexeltools.R;
import com.example.nexeltools.modelo.Carrinho;
import com.example.nexeltools.modelo.Compra;
import com.example.nexeltools.modelo.Produto;
import com.example.nexeltools.modelo.SingletonAPI;

import java.util.ArrayList;

public class ProdutosCompraAdapter extends BaseAdapter {

    private Context context;
    private ArrayList<Produto> produtos;
    private LayoutInflater inflater;

    public ProdutosCompraAdapter(Context context, ArrayList<Produto> produtos) {
        this.context = context;
        this.produtos = produtos;
        this.inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }

    @Override
    public int getCount() {
        return produtos.size();
    }

    @Override
    public Object getItem(int i) {
        return produtos.get(i);
    }

    @Override
    public long getItemId(int i) {
        return produtos.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

        if (view == null)
            view = inflater.inflate(R.layout.item_lista_detalhes_compra, null);

        ProdutosCompraAdapter.ViewHolderLista viewHolder = (ProdutosCompraAdapter.ViewHolderLista) view.getTag();
        if (viewHolder == null) {
            viewHolder = new ProdutosCompraAdapter.ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(produtos.get(i));


        return view;
    }

    private class ViewHolderLista {
        private TextView tvEstado, tvProduto, tvPreco;

        public ViewHolderLista(View view) {
            tvProduto = view.findViewById(R.id.tvNomeProduto);
            tvEstado = view.findViewById(R.id.tvEstado);
            tvPreco = view.findViewById(R.id.tvPreco);
        }

        public void update(Produto p) {
            tvProduto.setText(p.getNome());

            if(p.getEstado() == 1){
                tvEstado.setText("A processar...");
            } else if (p.getEstado() == 2) {
                tvEstado.setText("Em Entrega...");
            }else{
                tvEstado.setText("Entregue");
            }

            tvPreco.setText(p.getPreco()+"€");

        }
    }
}
