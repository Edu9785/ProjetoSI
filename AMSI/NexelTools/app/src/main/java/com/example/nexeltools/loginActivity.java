package com.example.nexeltools;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.nexeltools.modelo.singletonAPI;
import com.example.nexeltools.listeners.LoginListener;


public class LoginActivity extends AppCompatActivity implements LoginListener {

    private EditText txtUsername, txtPassword;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_login);

        txtUsername = findViewById(R.id.txtUsername);
        txtPassword = findViewById(R.id.txtPassword);
        Button btnLogin = findViewById(R.id.btnLogin);

        singletonAPI.getInstance(getApplicationContext()).setLoginListener(this);

        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String username = txtUsername.getText().toString().trim();
                String password = txtPassword.getText().toString().trim();

                if (username.isEmpty() || password.isEmpty()) {
                    Toast.makeText(LoginActivity.this, "Por favor, insira o username e password.", Toast.LENGTH_SHORT).show();
                } else {
                    singletonAPI.getInstance(getApplicationContext()).loginAPI(username, password, getApplicationContext());
                }
            }
        });
    }

    @Override
    public void onLoginSuccess(String token) {
        // Navegar para a próxima Activity ou fazer algo em caso de sucesso
        Toast.makeText(LoginActivity.this, "Login bem-sucedido!", Toast.LENGTH_SHORT).show();
        navigateToMain();
    }

    @Override
    public void onLoginFailure(String errorMessage) {
        // Exibir mensagem de erro ou outras ações em caso de falha
        Toast.makeText(LoginActivity.this, "Falha no login: " + errorMessage, Toast.LENGTH_SHORT).show();
    }

    private void navigateToMain() {
        Intent intent = new Intent(LoginActivity.this, MainActivity.class);
        startActivity(intent);
        finish();
    }
}

