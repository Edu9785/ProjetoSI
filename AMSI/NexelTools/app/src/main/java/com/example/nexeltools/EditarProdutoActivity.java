package com.example.nexeltools;

import android.Manifest;
import android.app.Activity;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Base64;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import com.example.nexeltools.listeners.CategoriaListener;
import com.example.nexeltools.listeners.EditarProdutoListener;
import com.example.nexeltools.modelo.Categoria;
import com.example.nexeltools.modelo.SingletonAPI;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;

public class EditarProdutoActivity extends AppCompatActivity implements CategoriaListener, EditarProdutoListener {

    private EditText txtNome, txtDesc, txtPreco;
    private Spinner spinnerCategorias;
    private ArrayList<Uri> imagens;
    private Button btnImagens, btnEditar;
    private int id_categoria, id_produto;
    private static final int PICK_IMAGES_REQUEST = 100;
    private ArrayList<String> encodedImageStrings;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_editar_produto);

        spinnerCategorias = findViewById(R.id.spinnerCategorias);
        txtNome = findViewById(R.id.txtNomeProduto);
        txtPreco = findViewById(R.id.txtPreco);
        txtDesc = findViewById(R.id.txtDesc);
        btnImagens = findViewById(R.id.btnImagens);
        btnEditar = findViewById(R.id.btnEditar);
        imagens = new ArrayList<>();
        encodedImageStrings = new ArrayList<>();

        Intent intentDados = getIntent();
        txtDesc.setText(intentDados.getStringExtra("desc"));
        txtNome.setText(intentDados.getStringExtra("nome"));
        txtPreco.setText((intentDados.getDoubleExtra("preco", 0) + ""));
        id_categoria = intentDados.getIntExtra("id_categoria", 0);
        id_produto = intentDados.getIntExtra("id", 0);

        SingletonAPI.getInstance(getApplicationContext()).setEditarProdutoListener(this);
        SingletonAPI.getInstance(getApplicationContext()).setCategoriaListener(this);
        SingletonAPI.getInstance(getApplicationContext()).getCategoriasApi(getApplicationContext());

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

        btnEditar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String nome = txtNome.getText().toString();
                String preco = txtPreco.getText().toString();
                String desc = txtDesc.getText().toString();

                if (nome.isEmpty() || preco.isEmpty() || desc.isEmpty()) {
                    Toast.makeText(getApplicationContext(), "Por favor, preencha todos os campos!", Toast.LENGTH_SHORT).show();
                } else {
                    SingletonAPI.getInstance(getApplicationContext()).EditarProdutoAPI(nome, desc, preco, id_categoria, id_produto, encodedImageStrings, getApplicationContext());
                }
            }
        });

        btnImagens.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (ContextCompat.checkSelfPermission(EditarProdutoActivity.this, Manifest.permission.READ_EXTERNAL_STORAGE) != PackageManager.PERMISSION_GRANTED) {
                    ActivityCompat.requestPermissions(EditarProdutoActivity.this, new String[]{Manifest.permission.READ_EXTERNAL_STORAGE}, 1);
                } else {
                    Intent intent = new Intent(Intent.ACTION_PICK);
                    intent.setType("image/*");
                    intent.putExtra(Intent.EXTRA_ALLOW_MULTIPLE, true);
                    startActivityForResult(Intent.createChooser(intent, "Selecionar Imagens"), PICK_IMAGES_REQUEST);
                }
            }
        });
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (requestCode == PICK_IMAGES_REQUEST && resultCode == Activity.RESULT_OK) {
            if (data.getClipData() != null) {
                int totalImages = data.getClipData().getItemCount();
                int imagesToSelect = Math.min(totalImages, 5);

                for (int i = 0; i < imagesToSelect; i++) {
                    Uri filepath = data.getClipData().getItemAt(i).getUri();
                    imagens.add(filepath);
                    encodeBitmapImage(filepath);
                }
            } else if (data.getData() != null) {
                Uri filepath = data.getData();
                imagens.add(filepath);
                encodeBitmapImage(filepath);
            }
        }
    }

    private void encodeBitmapImage(Uri filepath) {
        try {
            InputStream inputStream = getContentResolver().openInputStream(filepath);
            Bitmap bitmap = BitmapFactory.decodeStream(inputStream);
            ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
            bitmap.compress(Bitmap.CompressFormat.PNG, 100, byteArrayOutputStream);

            byte[] bytesOfImage = byteArrayOutputStream.toByteArray();
            String encodedImage = Base64.encodeToString(bytesOfImage, Base64.DEFAULT);
            encodedImageStrings.add(encodedImage);

        } catch (IOException e) {
            e.printStackTrace();
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

            for (int i = 0; i < categorias.size(); i++) {
                if (categorias.get(i).getId() == id_categoria) {
                    spinnerCategorias.setSelection(i);
                    break;
                }
            }
        } else {
            Toast.makeText(getApplicationContext(), "Nenhuma categoria encontrada.", Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public void onEditSuccess() {
        Intent intent = new Intent(EditarProdutoActivity.this, MainMenuActivity.class);
        startActivity(intent);
        Toast.makeText(getApplicationContext(), "Produto Editado", Toast.LENGTH_SHORT).show();
    }
}
