package com.example.nexeltools.adaptadores;

import android.content.Context;
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
import com.example.nexeltools.modelo.Produto;

import java.util.ArrayList;

public class VendasAdapter extends BaseAdapter {
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Produto> vendas;

    public VendasAdapter(Context context, ArrayList<Produto> vendas) {
        this.context = context;
        this.vendas = vendas;
        this.inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }

    @Override
    public int getCount() {
        return vendas.size();
    }

    @Override
    public Object getItem(int i) {
        return vendas.get(i);
    }

    @Override
    public long getItemId(int i) {
        return vendas.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if(inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

        if(view == null)
            view = inflater.inflate(R.layout.item_lista_vendas, null);

        VendasAdapter.ViewHolderLista viewHolder = (VendasAdapter.ViewHolderLista) view.getTag();
        if(viewHolder == null){
            viewHolder = new VendasAdapter.ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(vendas.get(i));

        return view;
    }

    private class ViewHolderLista{
        private TextView tvProduto, tvPreco;

        public ViewHolderLista(View view){
            tvProduto = view.findViewById(R.id.tvNome);
            tvPreco = view.findViewById(R.id.tvPreco);
        }

        public void update(Produto p){
            tvProduto.setText(p.getNome());
            tvPreco.setText(p.getPreco()+"€");

        }
    }
}
