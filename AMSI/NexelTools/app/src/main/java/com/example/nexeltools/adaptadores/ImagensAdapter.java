package com.example.nexeltools.adaptadores;

import android.content.Context;
import android.content.SharedPreferences;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.example.nexeltools.R;

import java.util.List;

public class ImagensAdapter extends RecyclerView.Adapter<ImagensAdapter.ImagemViewHolder> {

    private Context context;
    private List<String> imagens;
    private static final String KEY_IP = "ip";
    private static final String IP_NAME = "SettingsPreferences";

    public ImagensAdapter(Context context, List<String> imagens) {
        this.context = context;
        this.imagens = imagens;
    }

    @NonNull
    @Override
    public ImagemViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {

        View view = LayoutInflater.from(context).inflate(R.layout.item_pager_detalhes, parent, false);
        return new ImagemViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ImagemViewHolder holder, int position) {
        String imagemUrl = imagens.get(position);
        String baseUrl = "http://"+getIP(context)+"/";

        if (imagemUrl != null && !imagemUrl.isEmpty()) {
            Glide.with(context)
                    .load(baseUrl + imagemUrl)
                    .into(holder.imageView);
        } else {
            Glide.with(context)
                    .load(R.drawable.chave_estrela)
                    .into(holder.imageView);
        }
    }

    public static String getIP(Context context) {
        SharedPreferences sharedPreferences = context.getSharedPreferences(IP_NAME, Context.MODE_PRIVATE);
        return sharedPreferences.getString(KEY_IP, "172.22.21.215");
    }

    @Override
    public int getItemCount() {
        return imagens.size();
    }

    public static class ImagemViewHolder extends RecyclerView.ViewHolder {

        public ImageView imageView;

        public ImagemViewHolder(View itemView) {
            super(itemView);
            imageView = itemView.findViewById(R.id.imagemProduto);
        }
    }
}
