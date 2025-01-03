package com.example.nexeltools;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.nexeltools.listeners.LoginListener;
import com.example.nexeltools.modelo.singletonAPI;

public class loginActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_login);

        EditText txtUsername, txtPassword;
        Button btnLogin;

        btnLogin = findViewById(R.id.btnLogin);
        txtUsername = findViewById(R.id.txtEmail);
        txtPassword = findViewById(R.id.txtPassword);

        singletonAPI.getInstance(this).setLoginListener(new LoginListener() {
            @Override
            public void onLoginSuccess(String token) {
                Toast.makeText(loginActivity.this, "Login bem-sucedido!", Toast.LENGTH_SHORT).show();
                Intent intent = new Intent(loginActivity.this, MainActivity.class);  // Altere para sua Activity principal
                startActivity(intent);
                finish();
            }

            @Override
            public void onLoginFailure(String errorMessage) {
                Toast.makeText(loginActivity.this, "Erro: " + errorMessage, Toast.LENGTH_LONG).show();
            }
        });

        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String username = txtUsername.getText().toString().trim();
                String password = txtPassword.getText().toString().trim();

                if (username.isEmpty() || password.isEmpty()) {
                    Toast.makeText(loginActivity.this, "Por favor, insira o username e password.", Toast.LENGTH_SHORT).show();
                } else {
                    singletonAPI.getInstance(loginActivity.this).loginAPI(username, password, loginActivity.this);
                }
            }
        });
    }
}
