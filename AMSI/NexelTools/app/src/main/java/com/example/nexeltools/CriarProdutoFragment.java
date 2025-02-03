package com.example.nexeltools;

import android.app.Activity;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import android.provider.MediaStore;
import android.util.Base64;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.Spinner;
import android.widget.Toast;
import android.Manifest;

import com.example.nexeltools.listeners.CategoriaListener;
import com.example.nexeltools.listeners.CriarProdutoListener;
import com.example.nexeltools.modelo.Categoria;
import com.example.nexeltools.modelo.SingletonAPI;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link CriarProdutoFragment#newInstance} factory method to
 * create an instance of this fragment.
 */
public class CriarProdutoFragment extends Fragment implements CategoriaListener, CriarProdutoListener {

    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";
    private static final int PICK_IMAGES_REQUEST = 100;
    private Spinner spinnerCategorias;
    private EditText txtNome, txtDesc, txtPreco;
    private Button btnImagens, btnPublicar;
    private int id_categoria;
    private ArrayList<Uri> imagens;
    private ArrayList<String> encodedImageStrings;
    private LinearLayout imagesContainer;

    public CriarProdutoFragment() {
    }

    public static CriarProdutoFragment newInstance(String param1, String param2) {
        CriarProdutoFragment fragment = new CriarProdutoFragment();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_criar_produto, container, false);

        spinnerCategorias = view.findViewById(R.id.spinnerCategorias);
        txtNome = view.findViewById(R.id.txtNomeProduto);
        txtPreco = view.findViewById(R.id.txtPreco);
        txtDesc = view.findViewById(R.id.txtDesc);
        imagesContainer = view.findViewById(R.id.imagesContainer);
        btnImagens = view.findViewById(R.id.btnImagens);
        btnPublicar = view.findViewById(R.id.btnPublicar);
        imagens = new ArrayList<>();
        encodedImageStrings = new ArrayList<>();

        SingletonAPI.getInstance(getContext()).setCategoriaListener(this);
        SingletonAPI.getInstance(getContext()).setCriarProdutoListener(this);
        SingletonAPI.getInstance(getContext()).getCategoriasApi(getContext());

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

        btnPublicar.setOnClickListener(view1 -> {
            String nome = txtNome.getText().toString();
            String preco = txtPreco.getText().toString();
            String desc = txtDesc.getText().toString();

            if (nome.isEmpty() || preco.isEmpty() || desc.isEmpty()) {
                Toast.makeText(getContext(), "Por favor, Preencha todos os campos!", Toast.LENGTH_SHORT).show();
            } else {
                if (imagens.isEmpty()) {
                    Toast.makeText(getContext(), "Por favor, selecione ao menos uma imagem!", Toast.LENGTH_SHORT).show();
                } else {
                    SingletonAPI.getInstance(getContext()).criarProdutoAPI(nome, desc, preco, id_categoria, encodedImageStrings, getContext());
                }
            }
        });

        btnImagens.setOnClickListener(v -> {
            if (ContextCompat.checkSelfPermission(getContext(), Manifest.permission.READ_EXTERNAL_STORAGE) != PackageManager.PERMISSION_GRANTED) {
                ActivityCompat.requestPermissions(getActivity(), new String[]{Manifest.permission.READ_EXTERNAL_STORAGE}, 1);
            } else {
                Intent intent = new Intent(Intent.ACTION_PICK);
                intent.setType("image/*");
                intent.putExtra(Intent.EXTRA_ALLOW_MULTIPLE, true);
                startActivityForResult(Intent.createChooser(intent, "Selecionar Imagens"), PICK_IMAGES_REQUEST);
            }
        });

        return view;
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
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
            InputStream inputStream = requireContext().getContentResolver().openInputStream(filepath);
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
            ArrayAdapter<Categoria> adapter = new ArrayAdapter<>(getContext(), android.R.layout.simple_spinner_item, categorias);
            adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            spinnerCategorias.setAdapter(adapter);
        }
    }

    @Override
    public void onCreateSuccess() {
        FragmentManager fragmentManager = requireActivity().getSupportFragmentManager();
        fragmentManager.beginTransaction()
                .replace(R.id.container, new ProdutosFragment())
                .commit();

        Toast.makeText(getContext(), "Produto Criado com sucesso!", Toast.LENGTH_SHORT).show();
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode == 1) {
            if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                btnImagens.performClick();
            } else {

                Toast.makeText(getContext(), "Permissão negada para acessar as imagens!", Toast.LENGTH_SHORT).show();
            }
        }
    }
}
