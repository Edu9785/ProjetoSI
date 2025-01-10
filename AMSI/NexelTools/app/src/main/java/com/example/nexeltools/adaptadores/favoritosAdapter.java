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
import com.example.nexeltools.modelo.Favorito;
import com.example.nexeltools.modelo.Produto;
import com.example.nexeltools.modelo.singletonAPI;

import java.util.ArrayList;

public class favoritosAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Favorito> favoritos;
    private ImageButton btnCart;

    public favoritosAdapter(Context context, ArrayList<Favorito> favoritos) {
        this.context = context;
        this.favoritos = favoritos;
        this.inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }


    @Override
    public int getCount() {
        return favoritos.size();
    }

    @Override
    public Object getItem(int i) {
        return favoritos.get(i);
    }

    @Override
    public long getItemId(int i) {
        return favoritos.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if(inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

        if(view == null)
            view = inflater.inflate(R.layout.item_lista_favoritos, null);

        favoritosAdapter.ViewHolderLista viewHolder = (favoritosAdapter.ViewHolderLista) view.getTag();
        if(viewHolder == null){
            viewHolder = new favoritosAdapter.ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(favoritos.get(i));

        btnCart = view.findViewById(R.id.btnCart);
        Favorito favorito = favoritos.get(i);

        btnCart.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        ImageButton btnRemove = view.findViewById(R.id.btnRemoverFav);

        btnRemove.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                singletonAPI.getInstance(context).RemoverFavoritoApi(context, favorito.getId_produto());
            }
        });

        return view;
    }

    private class ViewHolderLista{
        private TextView tvProduto, tvVendedor, tvPreco;
        private ImageView imgProduto;

        public ViewHolderLista(View view){
            tvProduto = view.findViewById(R.id.textViewNome);
            tvVendedor = view.findViewById(R.id.textViewVendedor);
            tvPreco = view.findViewById(R.id.textViewPreco);
            imgProduto = view.findViewById(R.id.imageViewFav);
        }

        public void update(Favorito f){

            tvProduto.setText(f.getNome());
            tvVendedor.setText(f.getVendedor());
            tvPreco.setText(f.getPreco()+"€");

            String baseUrl = "http://192.168.1.69/";
            String imagemPath = f.getImagens().get(0);
            String imagemUrl = baseUrl + imagemPath;

            Glide.with(context)
                    .load(imagemUrl)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgProduto);
        }
    }
}
