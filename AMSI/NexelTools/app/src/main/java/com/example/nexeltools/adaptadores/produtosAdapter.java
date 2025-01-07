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
import com.example.nexeltools.modelo.Produto;

import java.util.ArrayList;
import java.util.List;

public class produtosAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Produto> produtosCatalogo;


    public produtosAdapter(Context context, ArrayList<Produto> produtos) {
        this.context = context;
        this.produtosCatalogo = produtosDisponiveis(produtos);
        this.inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }

    @Override
    public int getCount() {
        return produtosCatalogo.size();
    }

    @Override
    public Object getItem(int position) {
        return produtosCatalogo.get(position);
    }

    @Override
    public long getItemId(int position) {
        return produtosCatalogo.get(position).getId();
    }

    private ArrayList<Produto> produtosDisponiveis(ArrayList<Produto> produtos) {
        ArrayList<Produto> produtosDisponiveis = new ArrayList<>();
        for (Produto produto : produtos) {
            if (produto.getEstado() == 0) {
                produtosDisponiveis.add(produto);
            }
        }
        return produtosDisponiveis;
    }


    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {

        if(inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

        if(view == null)
            view = inflater.inflate(R.layout.item_produto, null);


        ViewHolderLista viewHolder = (ViewHolderLista) view.getTag();
        if(viewHolder == null){
            viewHolder = new ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(produtosCatalogo.get(i));

        return view;
    }

    private class ViewHolderLista{
        private TextView tvProduto, tvVendedor, tvPreco;
        private ImageView imgProduto;

        public ViewHolderLista(View view){
            tvProduto = view.findViewById(R.id.txtProduto);
            tvVendedor = view.findViewById(R.id.txtVendedor);
            tvPreco = view.findViewById(R.id.txtPreco);
            imgProduto = view.findViewById(R.id.imagemProduto);
        }

        public void update(Produto p){
                tvProduto.setText(p.getNome());
                tvVendedor.setText(p.getVendedor());
                tvPreco.setText(p.getPreco()+"€");

                String baseUrl = "http://192.168.1.153/";
                String imagemPath = p.getImagens().get(0);
                String imagemUrl = baseUrl + imagemPath;

                Glide.with(context)
                        .load(imagemUrl)
                        .diskCacheStrategy(DiskCacheStrategy.ALL)
                        .into(imgProduto);
        }
    }
}
