package com.example.nexeltools;

import android.content.Intent;
import android.os.Bundle;
import android.widget.ListView;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.nexeltools.adaptadores.CarrinhoAdapter;
import com.example.nexeltools.adaptadores.FaturaAdapter;
import com.example.nexeltools.listeners.FaturaListener;
import com.example.nexeltools.modelo.Fatura;
import com.example.nexeltools.modelo.SingletonAPI;

public class FaturaActivity extends AppCompatActivity implements FaturaListener {

    private TextView tvDatahora, tvNome, tvSubtotal, tvPrecoFatura, tvPrecoEnvio;
    private ListView produtosList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_fatura);

        tvDatahora = findViewById(R.id.tvDatahora);
        tvNome = findViewById(R.id.tvNome);
        produtosList = findViewById(R.id.produtosList);
        tvSubtotal = findViewById(R.id.tvSubtotal);
        tvPrecoFatura = findViewById(R.id.tvPrecoFatura);
        tvPrecoEnvio = findViewById(R.id.tvPrecoEnvio);

        Intent intent = getIntent();
        int id_compra = intent.getIntExtra("id_compra", 0);
        SingletonAPI.getInstance(getApplicationContext()).setFaturaListener(this);
        SingletonAPI.getInstance(getApplicationContext()).getFatura(getApplicationContext(), id_compra);
    }

    @Override
    public void onLoadFatura(Fatura fatura) {
        produtosList.setAdapter(new FaturaAdapter(getApplicationContext(), fatura));
        tvDatahora.setText(fatura.getDatahora());
        tvNome.setText(fatura.getComprador());
        tvSubtotal.setText(((fatura.getPrecofatura() - fatura.getExpedicaopreco())+" €"));
        tvPrecoEnvio.setText(fatura.getExpedicaopreco()+" €");
        tvPrecoFatura.setText(fatura.getPrecofatura()+" €");

    }
}