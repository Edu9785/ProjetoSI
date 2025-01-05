package com.example.nexeltools;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.nexeltools.modelo.singletonAPI;
import com.example.nexeltools.listeners.LoginListener;


public class loginActivity extends AppCompatActivity implements LoginListener {

    private EditText txtUsername, txtPassword;
    private Button btnLogin;
    private TextView btnCriarConta;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_login);

        txtUsername = findViewById(R.id.txtUsername);
        txtPassword = findViewById(R.id.txtPassword);
        btnLogin = findViewById(R.id.btnLogin);
        btnCriarConta = findViewById(R.id.tvCreateAccount);

        singletonAPI.getInstance(getApplicationContext()).setLoginListener(this);

        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String username = txtUsername.getText().toString().trim();
                String password = txtPassword.getText().toString().trim();

                if (username.isEmpty() || password.isEmpty()) {
                    Toast.makeText(loginActivity.this, "Por favor, preencha ambos os campos!", Toast.LENGTH_SHORT).show();
                } else {
                    singletonAPI.getInstance(getApplicationContext()).loginAPI(username, password, loginActivity.this);
                }
            }
        });

        btnCriarConta.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(loginActivity.this, RegistoActivity.class);
                startActivity(intent);
            }
        });
    }


    @Override
    public void onLoginSuccess(String token) {

        SharedPreferences sharedPreferences = getSharedPreferences("LoginPreferences", MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putString("auth_token", token);
        editor.apply();

        Toast.makeText(loginActivity.this, "Login bem-sucedido!", Toast.LENGTH_SHORT).show();
        navigateToMain();
    }



    private void navigateToMain() {
        Intent intent = new Intent(loginActivity.this, mainmenuActivity.class);
        startActivity(intent);
        finish();
    }
}

