package com.example.nexeltools;

import android.os.Bundle;
import android.widget.ListView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.nexeltools.adaptadores.ProdutosCompraAdapter;
import com.example.nexeltools.modelo.Compra;
import com.example.nexeltools.modelo.Produto;

import java.util.ArrayList;

public class DetalhesCompraActivity extends AppCompatActivity {
    private TextView datacompra, tvPagamento, tvEnvio, tvTotal;
    private ListView listViewProdutos;
    private ProdutosCompraAdapter adapter;
    private ArrayList<Produto> produtos;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhes_compra);

        listViewProdutos = findViewById(R.id.produtosList);
        datacompra = findViewById(R.id.tvDatahora);
        tvPagamento = findViewById(R.id.tvpagamento);
        tvEnvio = findViewById(R.id.tvMetodoEnvio);
        tvTotal = findViewById(R.id.tvPrecoCompra);

        Compra compraSelecionada = (Compra) getIntent().getSerializableExtra("compra");

        if (compraSelecionada != null) {

            produtos = compraSelecionada.getProdutos();
            datacompra.setText(compraSelecionada.getDatacompra());
            tvPagamento.setText(compraSelecionada.getMetodopagamento());
            tvEnvio.setText(compraSelecionada.getMetodoexpedicao());
            tvTotal.setText(compraSelecionada.getPrecototal()+" €");
            adapter = new ProdutosCompraAdapter(this, produtos);
            listViewProdutos.setAdapter(adapter);
        }
    }
}
