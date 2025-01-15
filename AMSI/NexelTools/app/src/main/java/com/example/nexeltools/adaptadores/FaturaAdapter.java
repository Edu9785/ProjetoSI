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
import com.example.nexeltools.modelo.Carrinho;
import com.example.nexeltools.modelo.Fatura;
import com.example.nexeltools.modelo.Produto;
import com.example.nexeltools.modelo.SingletonAPI;

public class FaturaAdapter extends BaseAdapter {

    private Context context;
    private Fatura fatura;
    private LayoutInflater inflater;

    public FaturaAdapter(Context context, Fatura fatura) {
        this.context = context;
        this.fatura = fatura;
        this.inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }

    @Override
    public int getCount() {
        return fatura.getLinhasfatura().size();
    }

    @Override
    public Object getItem(int i) {
        return fatura.getLinhasfatura().get(i);
    }

    @Override
    public long getItemId(int i) {
        return fatura.getLinhasfatura().get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {

        if (inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

        if (view == null)
            view = inflater.inflate(R.layout.item_lista_fatura, null);

        FaturaAdapter.ViewHolderLista viewHolder = (FaturaAdapter.ViewHolderLista) view.getTag();
        if (viewHolder == null) {
            viewHolder = new FaturaAdapter.ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(fatura.getLinhasfatura().get(i));

        return view;
    }

    private class ViewHolderLista {
        private TextView tvNomeProduto, tvVendedor, tvPreco;

        public ViewHolderLista(View view) {
            tvNomeProduto = view.findViewById(R.id.tvNomeProduto);
            tvVendedor = view.findViewById(R.id.tvVendedor);
            tvPreco = view.findViewById(R.id.tvPreco);
        }

        public void update(Produto p) {
            tvNomeProduto.setText(p.getNome());
            tvVendedor.setText(p.getVendedor());
            tvPreco.setText(p.getPreco()+"€");

        }
    }
}
