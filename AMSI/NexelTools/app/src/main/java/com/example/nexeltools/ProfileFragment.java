package com.example.nexeltools;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.example.nexeltools.listeners.ProfileListener;
import com.example.nexeltools.modelo.Profile;
import com.example.nexeltools.modelo.SingletonAPI;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link ProfileFragment#newInstance} factory method to
 * create an instance of this fragment.
 */
public class ProfileFragment extends Fragment implements ProfileListener {

    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";
    private TextView tvUsername, tvEmail, tvMorada, tvNif, tvTelemovel, tvNome;
    private Button btnEditProfile;


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

        SingletonAPI.getInstance(getContext()).setProfileListener(this);
        SingletonAPI.getInstance(getContext()).getProfileApi(getContext());

        btnEditProfile = view.findViewById(R.id.editProfileBtn);

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
}