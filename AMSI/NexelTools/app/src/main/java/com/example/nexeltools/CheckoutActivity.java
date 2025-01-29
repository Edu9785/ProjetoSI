package com.example.nexeltools;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.nexeltools.listeners.CheckoutListener;
import com.example.nexeltools.listeners.MetodoexpedicaoListener;
import com.example.nexeltools.listeners.MetodopagamentoListener;
import com.example.nexeltools.modelo.Categoria;
import com.example.nexeltools.modelo.Metodoexpedicao;
import com.example.nexeltools.modelo.Metodopagamento;
import com.example.nexeltools.modelo.SingletonAPI;

import java.util.ArrayList;

public class CheckoutActivity extends AppCompatActivity implements MetodoexpedicaoListener, MetodopagamentoListener, CheckoutListener {

    private Spinner spinnerpagamento, spinnerexpedicoes;
    private int id_metodopagamento, id_metodoexpedicao;
    private Button btnPagar;
    private TextView tvPrecoTotal;
    private double valorCarrinho = 0;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_checkout);
        spinnerpagamento = findViewById(R.id.spinnerPagamento);
        spinnerexpedicoes = findViewById(R.id.spinnerExpedicoes);
        btnPagar = findViewById(R.id.btnPagar);
        tvPrecoTotal = findViewById(R.id.txtPrecoTotal);
        SingletonAPI.getInstance(getApplicationContext()).setCheckoutListener(this);
        SingletonAPI.getInstance(getApplicationContext()).setExpedicaoListener(this);
        SingletonAPI.getInstance(getApplicationContext()).setPagamentoListener(this);
        SingletonAPI.getInstance(getApplicationContext()).getPagamentosApi(getApplicationContext());
        SingletonAPI.getInstance(getApplicationContext()).getExpedicoesApi(getApplicationContext());
        Intent intent = getIntent();
        valorCarrinho = intent.getDoubleExtra("totalcarrinho", 0);


        spinnerpagamento.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {
                Metodopagamento pagamento = (Metodopagamento) adapterView.getItemAtPosition(i);
                id_metodopagamento = pagamento.getId();
            }

            @Override
            public void onNothingSelected(AdapterView<?> adapterView) {

            }
        });

        spinnerexpedicoes.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {
                Metodoexpedicao expedicao = (Metodoexpedicao) adapterView.getItemAtPosition(i);
                id_metodoexpedicao = expedicao.getId();
                tvPrecoTotal.setText((valorCarrinho + expedicao.getPreco())+"€");
            }

            @Override
            public void onNothingSelected(AdapterView<?> adapterView) {

            }
        });

        btnPagar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                SingletonAPI.getInstance(getApplicationContext()).checkoutAPI(id_metodopagamento, id_metodoexpedicao, getApplicationContext());
            }
        });
    }

    @Override
    public void LoadMetodosExpedicao(ArrayList<Metodoexpedicao> expedicoes) {
        if (expedicoes != null && !expedicoes.isEmpty()) {

            ArrayAdapter<Metodoexpedicao> adapter = new ArrayAdapter<>(
                    getApplicationContext(),
                    android.R.layout.simple_spinner_item,
                    expedicoes
            );
            adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

            spinnerexpedicoes.setAdapter(adapter);
        } else {
            Toast.makeText(getApplicationContext(), "Nenhuma Método de envio encontrado.", Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public void LoadMetodosPagamento(ArrayList<Metodopagamento> pagamentos) {
        if (pagamentos != null && !pagamentos.isEmpty()) {

            ArrayAdapter<Metodopagamento> adapter = new ArrayAdapter<>(
                    getApplicationContext(),
                    android.R.layout.simple_spinner_item,
                    pagamentos
            );
            adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

            spinnerpagamento.setAdapter(adapter);
        } else {
            Toast.makeText(getApplicationContext(), "Nenhuma Método de pagamento encontrado.", Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public void onCheckoutSuccess() {
        Intent intent = new Intent(CheckoutActivity.this, MainMenuActivity.class);
        startActivity(intent);
        Toast.makeText(getApplicationContext(), "Compra realizada com sucesso", Toast.LENGTH_SHORT).show();
    }
}