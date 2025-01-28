package com.example.nexeltools;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ListView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.nexeltools.adaptadores.ComprasAdapter;
import com.example.nexeltools.adaptadores.ProdutosAdapter;
import com.example.nexeltools.adaptadores.VendasAdapter;
import com.example.nexeltools.listeners.HistoricoListener;
import com.example.nexeltools.modelo.Compra;
import com.example.nexeltools.modelo.HistoricoDBHelper;
import com.example.nexeltools.modelo.Produto;
import com.example.nexeltools.modelo.SingletonAPI;

import java.util.ArrayList;

public class HistoricoActivity extends AppCompatActivity implements HistoricoListener {

    ListView vendasList, comprasList;
    ArrayList<Produto> vendas;
    ArrayList<Compra> compras;
    VendasAdapter vendasAdapter;
    ComprasAdapter comprasAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_historico);
        vendasList = findViewById(R.id.vendasList);
        comprasList = findViewById(R.id.comprasList);
        vendas = new ArrayList<>();
        compras = new ArrayList<>();
        vendasAdapter = new VendasAdapter(getApplicationContext(), vendas);
        comprasAdapter = new ComprasAdapter(getApplicationContext(), compras);
        vendasList.setAdapter(vendasAdapter);
        comprasList.setAdapter(comprasAdapter);

        SingletonAPI.getInstance(getApplicationContext()).setHistoricoListener(this);
        SingletonAPI.getInstance(getApplicationContext()).getProdutosVendidosApi(getApplicationContext());
        SingletonAPI.getInstance(getApplicationContext()).getComprasApi(getApplicationContext());
    }


    @Override
    public void onRefreshListaCompras(ArrayList<Compra> compras) {
        if(compras != null){
            comprasList.setAdapter(new ComprasAdapter(getApplicationContext(), compras));
        }
    }

    @Override
    public void onRefreshListaVendas(ArrayList<Produto> vendas) {
        if(vendas != null){
            vendasList.setAdapter(new VendasAdapter(getApplicationContext(), vendas));
        }
    }
}