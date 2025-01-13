package com.example.nexeltools.adaptadores;

import android.app.AlertDialog;
import android.content.Context;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.nexeltools.R;
import com.example.nexeltools.modelo.Favorito;
import com.example.nexeltools.modelo.Produto;
import com.example.nexeltools.modelo.SingletonAPI;

import java.util.ArrayList;

public class ProdutosVendedorAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Produto> produtosvendedor;
    private ImageButton btnRemoverProduto;

    public ProdutosVendedorAdapter(Context context, ArrayList<Produto> produtosvendedor) {
        this.context = context;
        this.inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        this.produtosvendedor = produtosvendedor;
    }

    @Override
    public int getCount() {
        return produtosvendedor.size();
    }

    @Override
    public Object getItem(int i) {
        return produtosvendedor.get(i);
    }

    @Override
    public long getItemId(int i) {
        return produtosvendedor.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if(inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

        if(view == null)
            view = inflater.inflate(R.layout.item_lista_vender, null);

        ProdutosVendedorAdapter.ViewHolderLista viewHolder = (ProdutosVendedorAdapter.ViewHolderLista) view.getTag();
        if(viewHolder == null){
            viewHolder = new ProdutosVendedorAdapter.ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(produtosvendedor.get(i));

        btnRemoverProduto = view.findViewById(R.id.btnRemoverProduto);

        Produto produto = produtosvendedor.get(i);

        btnRemoverProduto.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                int produtoId = produto.getId();


                new AlertDialog.Builder(context)
                        .setTitle("Confirmar Exclusão")
                        .setMessage("Tem certeza de que deseja excluir o produto \"" + produto.getNome() + "\"?")
                        .setPositiveButton("Sim", (dialog, which) -> {
                            SingletonAPI.getInstance(context).RemoverProdutoApi(context, produtoId);
                        })
                        .setNegativeButton("Não", (dialog, which) -> dialog.dismiss())
                        .show();
            }
        });


        return view;
    }

    private class ViewHolderLista{
        private TextView tvProduto, tvPreco;
        private ImageView imgProduto;

        public ViewHolderLista(View view){
            tvProduto = view.findViewById(R.id.textViewNome);
            tvPreco = view.findViewById(R.id.textViewPreco);
            imgProduto = view.findViewById(R.id.imgProdutoVender);
        }

        public void update(Produto p){
            tvProduto.setText(p.getNome());
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
