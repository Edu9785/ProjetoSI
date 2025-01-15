package com.example.nexeltools.adaptadores;

import android.content.Context;
import android.content.Intent;
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
import com.example.nexeltools.DetalhesProdutoActivity;
import com.example.nexeltools.R;
import com.example.nexeltools.modelo.Avaliacao;
import com.example.nexeltools.modelo.Produto;
import com.example.nexeltools.modelo.SingletonAPI;

import java.util.ArrayList;

public class AvaliacaoAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Avaliacao> avaliacoes;

    public AvaliacaoAdapter(Context context, ArrayList<Avaliacao> avaliacoes) {
        this.context = context;
        this.inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        this.avaliacoes = avaliacoes;
    }

    @Override
    public int getCount() {
        return avaliacoes.size();
    }

    @Override
    public Object getItem(int i) {
        return avaliacoes.get(i);
    }

    @Override
    public long getItemId(int i) {
        return avaliacoes.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if(inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

        if(view == null)
            view = inflater.inflate(R.layout.item_lista_avaliacao, null);

        AvaliacaoAdapter.ViewHolderLista viewHolder = (AvaliacaoAdapter.ViewHolderLista) view.getTag();
        if(viewHolder == null){
            viewHolder = new AvaliacaoAdapter.ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(avaliacoes.get(i));

        return view;
    }

    private class ViewHolderLista{
        private TextView tvUsername, tvAvaliacao, tvComentario;


        public ViewHolderLista(View view){
            tvUsername = view.findViewById(R.id.tvUsername);
            tvAvaliacao = view.findViewById(R.id.tvAvaliacao);
            tvComentario = view.findViewById(R.id.tvComentario);
        }

        public void update(Avaliacao a){
            tvUsername.setText(a.getUsername());
            tvAvaliacao.setText(a.getAvaliacao()+"");
            tvComentario.setText(a.getComentario());
        }
    }
}
