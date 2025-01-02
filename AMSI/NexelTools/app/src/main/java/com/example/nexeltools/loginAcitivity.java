package com.example.nexeltools;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

public class loginAcitivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_login);

        EditText txtUsername, txtPassword;
        Button btnLogin;

        btnLogin = findViewById(R.id.btnLogin);
        txtUsername = findViewById(R.id.txtEmail);
        txtPassword = findViewById(R.id.txtPassword);

        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                String username = txtUsername.getText().toString().trim();
                String password = txtPassword.getText().toString().trim();


                if (username.isEmpty() || password.isEmpty()) {
                    Toast.makeText(loginAcitivity.this, "Preencha todos os campos!", Toast.LENGTH_SHORT).show();
                }
                else
                {
                    singletonAPI API = singletonAPI.getInstance();

                    String token = API.login(username, password);

                    if(token!=null)
                    {
                        Toast.makeText(loginAcitivity.this, "Token: " + token, Toast.LENGTH_SHORT).show();
                    }
                    else
                    {
                        Toast.makeText(loginAcitivity.this, "Falha no login verifique as suas credenciais", Toast.LENGTH_SHORT).show();
                    }
                }


            }
        });

    }
}