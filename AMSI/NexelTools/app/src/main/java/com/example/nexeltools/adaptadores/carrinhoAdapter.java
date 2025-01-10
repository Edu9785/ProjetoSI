package com.example.nexeltools.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.nexeltools.R;
import com.example.nexeltools.modelo.Carrinho;
import com.example.nexeltools.modelo.Produto;

public class carrinhoAdapter extends BaseAdapter {

    private Context context;
    private Carrinho carrinho;
    private LayoutInflater inflater;

    public carrinhoAdapter(Context context, Carrinho carrinho) {
        this.context = context;
        this.carrinho = carrinho;
        this.inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }

    @Override
    public int getCount() {
        return carrinho.getProdutos().size();
    }

    @Override
    public Object getItem(int i) {
        return carrinho.getProdutos().get(i);
    }

    @Override
    public long getItemId(int i) {
        return carrinho.getProdutos().get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

        if (view == null)
            view = inflater.inflate(R.layout.item_lista_carrinho, null);

        carrinhoAdapter.ViewHolderLista viewHolder = (carrinhoAdapter.ViewHolderLista) view.getTag();
        if (viewHolder == null) {
            viewHolder = new carrinhoAdapter.ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(carrinho.getProdutos().get(i));

        return view;
    }

    private class ViewHolderLista {
        private TextView tvProduto, tvVendedor, tvPreco;
        private ImageView imgProduto;

        public ViewHolderLista(View view) {
            tvProduto = view.findViewById(R.id.textViewNome);
            tvVendedor = view.findViewById(R.id.textViewVendedor);
            tvPreco = view.findViewById(R.id.textViewPreco);
            imgProduto = view.findViewById(R.id.imageViewCarrinho);
        }

        public void update(Produto p) {
            tvProduto.setText(p.getNome());
            tvVendedor.setText(p.getVendedor());
            tvPreco.setText(p.getPreco()+"");

            String baseUrl = "http://192.168.1.69/";
            String imagemPath = p.getImagens().get(0);
            String imagemUrl = baseUrl + imagemPath;

            Glide.with(context)
                    .load(imagemUrl)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgProduto);
        }
    }

}
