package com.example.nexeltools.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.example.nexeltools.R;
import com.example.nexeltools.modelo.Compra;
import com.example.nexeltools.modelo.Produto;

import java.util.ArrayList;

public class ComprasAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Compra> compras;

    public ComprasAdapter(Context context, ArrayList<Compra> compras) {
        this.context = context;
        this.compras = compras;
        this.inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }


    @Override
    public int getCount() {
        return compras.size();
    }

    @Override
    public Object getItem(int i) {
        return compras.get(i);
    }

    @Override
    public long getItemId(int i) {
        return compras.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if(inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

        if(view == null)
            view = inflater.inflate(R.layout.item_lista_compras, null);

        ComprasAdapter.ViewHolderLista viewHolder = (ComprasAdapter.ViewHolderLista) view.getTag();
        if(viewHolder == null){
            viewHolder = new ComprasAdapter.ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(compras.get(i));

        return view;
    }

    private class ViewHolderLista{
        private TextView tvDataHora, tvPreco;

        public ViewHolderLista(View view){
            tvDataHora = view.findViewById(R.id.tvDataHora);
            tvPreco = view.findViewById(R.id.tvPreco);
        }

        public void update(Compra c){
            tvDataHora.setText(c.getDatacompra());
            tvPreco.setText(c.getPrecototal()+"€");

        }
    }
}
