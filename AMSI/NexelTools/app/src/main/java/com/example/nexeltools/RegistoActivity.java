package com.example.nexeltools;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.nexeltools.listeners.RegistarListener;
import com.example.nexeltools.modelo.SingletonAPI;

public class RegistoActivity extends AppCompatActivity implements RegistarListener {

    private EditText txtUsername, txtPassword, txtEmail, txtNome, txtNif, txtTelemovel, txtMorada;
    private Button btnCriarConta;

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_registar);

        txtUsername = findViewById(R.id.txtUsername);
        txtPassword = findViewById(R.id.txtPassword);
        btnCriarConta = findViewById(R.id.btnCriarConta);
        txtNome = findViewById(R.id.txtNome);
        txtEmail = findViewById(R.id.txtEmail);
        txtNif = findViewById(R.id.txtNif);
        txtTelemovel = findViewById(R.id.txtTelemovel);
        txtMorada = findViewById(R.id.txtMorada);

        SingletonAPI.getInstance(getApplicationContext()).setRegistarListener(this);

        btnCriarConta.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String username = txtUsername.getText().toString().trim();
                String password = txtPassword.getText().toString().trim();
                String email = txtEmail.getText().toString().trim();
                String nome = txtNome.getText().toString();
                String nif = txtNif.getText().toString().trim();
                String telemovel = txtTelemovel.getText().toString().trim();
                String morada = txtMorada.getText().toString();

                if (username.isEmpty() || password.isEmpty() || email.isEmpty() || nome.isEmpty() || nif.isEmpty() || telemovel.isEmpty() || morada.isEmpty()) {
                    Toast.makeText(RegistoActivity.this, "Por favor, preencha todos os campos!", Toast.LENGTH_SHORT).show();
                } else {
                    SingletonAPI.getInstance(getApplicationContext()).registarAPI(username, password,  email, nome, nif, telemovel, morada,RegistoActivity.this);
                }
            }
        });
    }

    @Override
    public void onRegistarSuccess() {
        Toast.makeText(RegistoActivity.this, "Conta criada com sucesso!", Toast.LENGTH_LONG).show();
        Intent intent = new Intent(RegistoActivity.this, LoginActivity.class);
        startActivity(intent);
        finish();
    }
}