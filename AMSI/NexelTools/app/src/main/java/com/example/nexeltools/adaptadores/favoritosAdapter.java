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
import com.example.nexeltools.modelo.Favorito;
import com.example.nexeltools.modelo.SingletonAPI;

import java.util.ArrayList;

public class FavoritosAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Favorito> favoritos;
    private ImageButton btnCart;
    private static final String KEY_IP = "ip";
    private static final String IP_NAME = "SettingsPreferences";

    public FavoritosAdapter(Context context, ArrayList<Favorito> favoritos) {
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

        FavoritosAdapter.ViewHolderLista viewHolder = (FavoritosAdapter.ViewHolderLista) view.getTag();
        if(viewHolder == null){
            viewHolder = new FavoritosAdapter.ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(favoritos.get(i));

        btnCart = view.findViewById(R.id.btnCart);
        Favorito favorito = favoritos.get(i);
        ImageButton btnRemove = view.findViewById(R.id.btnRemoverFav);

        btnRemove.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SingletonAPI.getInstance(context).RemoverFavoritoApi(context, favorito.getId_produto());
            }
        });

        btnCart.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SingletonAPI.getInstance(context).addCarrinhoApi(context, favorito.getId_produto(), true);
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

            String baseUrl = "http://"+getIP(context)+"/";

            if (f.getImagens() != null && !f.getImagens().isEmpty()) {
                String imagemPath = f.getImagens().get(0);
                String imagemUrl = baseUrl + imagemPath;

                Glide.with(context)
                        .load(imagemUrl)
                        .diskCacheStrategy(DiskCacheStrategy.ALL)
                        .into(imgProduto);
            } else {

                Glide.with(context)
                        .load(R.drawable.chave_estrela)
                        .into(imgProduto);
            }
        }

    }

    public static String getIP(Context context) {
        SharedPreferences sharedPreferences = context.getSharedPreferences(IP_NAME, Context.MODE_PRIVATE);
        return sharedPreferences.getString(KEY_IP, "172.22.21.215");
    }
}
