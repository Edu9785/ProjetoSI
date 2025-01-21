package com.example.nexeltools;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.nexeltools.listeners.EditProfileListener;
import com.example.nexeltools.modelo.SingletonAPI;

public class EditProfileActivity extends AppCompatActivity implements EditProfileListener {

    private TextView txtUsername, txtEmail, txtMorada, txtNif, txtTelemovel, txtNome;
    private Button btnEdit;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_edit_profile);

        txtNome = findViewById(R.id.txtNome);
        txtUsername = findViewById(R.id.txtUsername);
        txtEmail = findViewById(R.id.txtEmail);
        txtMorada = findViewById(R.id.txtMorada);
        txtNif = findViewById(R.id.txtNif);
        txtTelemovel = findViewById(R.id.txtTelemovel);
        btnEdit = findViewById(R.id.btnEditarProfile);

        Intent intent = getIntent();

        txtNome.setText(intent.getStringExtra("Nome"));
        txtUsername.setText(intent.getStringExtra("username"));
        txtEmail.setText(intent.getStringExtra("Email"));
        txtMorada.setText(intent.getStringExtra("Morada"));
        txtNif.setText(intent.getStringExtra("Nif"));
        txtTelemovel.setText(intent.getStringExtra("Telemovel"));


        SingletonAPI.getInstance(getApplicationContext()).setEditProfileListener(this);

        btnEdit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String username = txtUsername.getText().toString().trim();
                String email = txtEmail.getText().toString().trim();
                String nome = txtNome.getText().toString();
                String nif = txtNif.getText().toString().trim();
                String telemovel = txtTelemovel.getText().toString().trim();
                String morada = txtMorada.getText().toString();

                if (username.isEmpty() || email.isEmpty() || nome.isEmpty() || nif.isEmpty() || telemovel.isEmpty() || morada.isEmpty()) {
                    Toast.makeText(EditProfileActivity.this, "Por favor, preencha todos os campos!", Toast.LENGTH_SHORT).show();
                } else {
                    SingletonAPI.getInstance(getApplicationContext()).editProfileAPI(username, email, nome, nif, telemovel, morada,EditProfileActivity.this);
                }
            }
        });
    }

    @Override
    public void editProfileSucess() {
        Toast.makeText(getApplicationContext(), "Perfil atualizado com sucesso!", Toast.LENGTH_LONG).show();
        Intent intent = new Intent(EditProfileActivity.this, MainMenuActivity.class);
        startActivity(intent);
    }
}