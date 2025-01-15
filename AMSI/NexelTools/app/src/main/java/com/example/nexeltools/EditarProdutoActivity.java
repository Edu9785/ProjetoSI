package com.example.nexeltools;

import android.app.Activity;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.nexeltools.listeners.CategoriaListener;
import com.example.nexeltools.modelo.Categoria;

import java.util.ArrayList;

public class EditarProdutoActivity extends AppCompatActivity implements CategoriaListener {

    private EditText txtNome, txtDesc, txtPreco;
    private Spinner spinnerCategorias;
    private ArrayList<Uri> imagens;
    private Button btnImagens, btnEditar;
    private int id_categoria;
    private static final int PICK_IMAGES_REQUEST = 100;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_editar_produto);
        spinnerCategorias = findViewById(R.id.spinnerCategorias);
        txtNome = findViewById(R.id.txtNomeProduto);
        txtPreco = findViewById(R.id.txtPreco);
        txtDesc = findViewById(R.id.txtDesc);
        btnImagens = findViewById(R.id.btnImagens);
        imagens = new ArrayList<>();

        Intent intentDados = getIntent();
        txtDesc.setText(intentDados.getStringExtra("desc"));
        txtNome.setText(intentDados.getStringExtra("nome"));
        txtPreco.setText((intentDados.getDoubleExtra("preco", 0)+""));

        spinnerCategorias.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {
                Categoria categoria = (Categoria) adapterView.getItemAtPosition(i);
                id_categoria = categoria.getId();
            }

            @Override
            public void onNothingSelected(AdapterView<?> adapterView) {

            }
        });

        btnImagens.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(Intent.ACTION_PICK, MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
                intent.putExtra(Intent.EXTRA_ALLOW_MULTIPLE, true);
                startActivityForResult(intent, PICK_IMAGES_REQUEST);
            }
        });
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (requestCode == PICK_IMAGES_REQUEST && resultCode == Activity.RESULT_OK) {
            if (data.getClipData() != null) {

                int count = data.getClipData().getItemCount();
                for (int i = 0; i < count; i++) {
                    Uri imageUri = data.getClipData().getItemAt(i).getUri();
                    imagens.add(imageUri);
                }
            } else if (data.getData() != null) {

                Uri imageUri = data.getData();
                imagens.add(imageUri);
            }

            Toast.makeText(getApplicationContext(), "Imagens selecionadas: " + imagens.size(), Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public void LoadCategorias(ArrayList<Categoria> categorias) {
        if (categorias != null && !categorias.isEmpty()) {

            ArrayAdapter<Categoria> adapter = new ArrayAdapter<>(
                    this,
                    android.R.layout.simple_spinner_item,
                    categorias
            );
            adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

            spinnerCategorias.setAdapter(adapter);
        } else {
            Toast.makeText(getApplicationContext(), "Nenhuma categoria encontrada.", Toast.LENGTH_SHORT).show();
        }
    }
}