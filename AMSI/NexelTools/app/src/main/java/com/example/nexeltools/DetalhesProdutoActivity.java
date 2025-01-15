package com.example.nexeltools;

import android.content.Intent;
import android.os.Bundle;
import android.widget.ListView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;
import androidx.viewpager2.widget.ViewPager2;

import com.example.nexeltools.adaptadores.AvaliacaoAdapter;
import com.example.nexeltools.adaptadores.ImagensAdapter;
import com.example.nexeltools.listeners.ProdutoListener;
import com.example.nexeltools.modelo.Avaliacao;
import com.example.nexeltools.modelo.Produto;
import com.example.nexeltools.modelo.SingletonAPI;

import java.util.ArrayList;

public class DetalhesProdutoActivity extends AppCompatActivity implements ProdutoListener{

    private TextView tvNome, tvPreco, tvVendedor, tvAvaliacao, tvDesc;
    private ViewPager2 imgProduto;
    private ListView listviewavaliacao;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_detalhes_produto);

        tvPreco = findViewById(R.id.tvPreco);
        tvNome = findViewById(R.id.tvNome);
        tvVendedor = findViewById(R.id.tvVendedor);
        tvAvaliacao = findViewById(R.id.tvAvaliacao);
        tvDesc = findViewById(R.id.tvDesc);
        imgProduto = findViewById(R.id.viewPager);
        listviewavaliacao = findViewById(R.id.listViewAvaliacao);

        Intent intent = getIntent();
        int id_produto = intent.getIntExtra("id_produto", 0);
        int id_vendedor = intent.getIntExtra("id_vendedor", 0);
        SingletonAPI.getInstance(getApplicationContext()).setProdutoListener(this);
        SingletonAPI.getInstance(getApplicationContext()).getProduto(getApplicationContext(), id_produto);
        SingletonAPI.getInstance(getApplicationContext()).getAvaliacoesApi(getApplicationContext(), id_vendedor);

    }

    @Override
    public void detalhesProduto(Produto p) {
        imgProduto.setAdapter(new ImagensAdapter(getApplicationContext(), p.getImagens()));
        tvPreco.setText(p.getPreco()+" €");
        tvNome.setText(p.getNome());
        tvVendedor.setText(p.getVendedor());
        tvDesc.setText(p.getDesc());
        tvAvaliacao.setText(p.getAvaliacao()+"");
    }

    @Override
    public void onRefreshListaAvaliacao(ArrayList<Avaliacao> avaliacoes) {
        if(avaliacoes != null){
            listviewavaliacao.setAdapter(new AvaliacaoAdapter(getApplicationContext(), avaliacoes));
        }
    }
}