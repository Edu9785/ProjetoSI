package com.example.nexeltools.adaptadores;

import android.content.Context;
import android.util.Log;
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
import com.example.nexeltools.modelo.SingletonAPI;

import java.util.ArrayList;

public class ProdutosAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Produto> produtosCatalogo;
    private ImageButton btnFavorito, btnCart;


    public ProdutosAdapter(Context context, ArrayList<Produto> produtos) {
        this.context = context;
        this.produtosCatalogo = produtosDisponiveis(produtos);
        this.inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }

    @Override
    public int getCount() {
        return produtosCatalogo.size();
    }

    @Override
    public Object getItem(int i) {
        return produtosCatalogo.get(i);
    }

    @Override
    public long getItemId(int i) {
        return produtosCatalogo.get(i).getId();
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
            view = inflater.inflate(R.layout.item_lista_produto, null);

        ViewHolderLista viewHolder = (ViewHolderLista) view.getTag();
        if(viewHolder == null){
            viewHolder = new ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(produtosCatalogo.get(i));

        btnFavorito = view.findViewById(R.id.btnFavorito);
        Produto produto = produtosCatalogo.get(i);

        btnFavorito.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                int produtoId = produto.getId();
                Log.d("Favorito", "Produto ID: " + produtoId);
                SingletonAPI.getInstance(context).addFavoritoApi(context, produtoId);
            }
        });

        btnCart = view.findViewById(R.id.btnCarrinho);

        btnCart.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                int produtoId = produto.getId();
                SingletonAPI.getInstance(context).addCarrinhoApi(context, produtoId, false);
            }
        });

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
