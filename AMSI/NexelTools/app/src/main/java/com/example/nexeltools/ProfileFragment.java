package com.example.nexeltools;

import android.app.AlertDialog;
import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.example.nexeltools.adaptadores.ProdutosAdapter;
import com.example.nexeltools.adaptadores.ProdutosVendedorAdapter;
import com.example.nexeltools.listeners.ProfileListener;
import com.example.nexeltools.modelo.Produto;
import com.example.nexeltools.modelo.Profile;
import com.example.nexeltools.modelo.SingletonAPI;

import java.util.ArrayList;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link ProfileFragment#newInstance} factory method to
 * create an instance of this fragment.
 */
public class ProfileFragment extends Fragment implements ProfileListener {

    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";
    private TextView tvUsername, tvEmail, tvMorada, tvNif, tvTelemovel, tvNome;
    private Button btnEditProfile, btnHistorico;
    private ImageButton btnLogOut;
    private ListView produtosvendedorList;


    public ProfileFragment() {

    }


    public static ProfileFragment newInstance(String param1, String param2) {
        ProfileFragment fragment = new ProfileFragment();
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

        View view = inflater.inflate(R.layout.fragment_profile, container, false);

        tvNome = view.findViewById(R.id.tvNome);
        tvUsername = view.findViewById(R.id.tvUsername);
        tvEmail = view.findViewById(R.id.tvEmail);
        tvMorada = view.findViewById(R.id.tvMorada);
        tvNif = view.findViewById(R.id.tvNif);
        tvTelemovel = view.findViewById(R.id.tvTelemovel);
        produtosvendedorList = view.findViewById(R.id.produtosVendedorList);

        SingletonAPI.getInstance(getContext()).setProfileListener(this);
        SingletonAPI.getInstance(getContext()).getProfileApi(getContext());
        SingletonAPI.getInstance(getContext()).getProdutosVendedorApi(getContext());

        btnEditProfile = view.findViewById(R.id.editProfileBtn);
        btnHistorico = view.findViewById(R.id.historicoBtn);
        btnLogOut = view.findViewById(R.id.btnLogOut);

        btnEditProfile.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(view.getContext(), EditProfileActivity.class);
                intent.putExtra("username", tvUsername.getText());
                intent.putExtra("Email", tvEmail.getText());
                intent.putExtra("Nome", tvNome.getText());
                intent.putExtra("Morada", tvMorada.getText());
                intent.putExtra("Nif", tvNif.getText());
                intent.putExtra("Telemovel", tvTelemovel.getText());
                startActivity(intent);
            }
        });

        btnHistorico.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(view.getContext(), HistoricoActivity.class);
                startActivity(intent);
            }
        });

        btnLogOut.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                new AlertDialog.Builder(getContext())
                        .setTitle("Logout")
                        .setMessage("Tem certeza que deseja fazer logout?")
                        .setPositiveButton("Sim", (dialog, which) -> {
                            Intent intent = new Intent(getContext(), LoginActivity.class);
                            startActivity(intent);
                            Toast.makeText(getContext(), "Logout efetuado com sucesso!", Toast.LENGTH_SHORT).show();
                        })
                        .setNegativeButton("Não", (dialog, which) -> dialog.dismiss())
                        .show();
            }
        });

        return view;
    }

    @Override
    public void onLoadProfile(Profile profile) {
        if(profile != null){
            tvNome.setText(profile.getNome());
            tvUsername.setText(profile.getUsername());
            tvEmail.setText(profile.getEmail());
            tvMorada.setText(profile.getMorada());
            tvNif.setText(profile.getNif()+"");
            tvTelemovel.setText(profile.getTelemovel()+"");
        }else{
            Toast.makeText(getContext(), "Erro ao carregar o perfil", Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public void onRefreshListaProdutosVendedor(ArrayList<Produto> produtosvendedor) {
        if(produtosvendedor != null){
            produtosvendedorList.setAdapter(new ProdutosVendedorAdapter(getContext(), produtosvendedor));
        }
    }

    @Override
    public void onDeleteProductSuccess() {
        Toast.makeText(getContext(), "Produto deletado com sucesso!", Toast.LENGTH_SHORT).show();
        SingletonAPI.getInstance(getContext()).getProdutosVendedorApi(getContext());
    }
}