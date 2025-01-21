package com.example.nexeltools;

import android.content.Intent;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;

import com.google.android.material.bottomnavigation.BottomNavigationView;

public class MainMenuActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_main_menu);

        BottomNavigationView bottomNav = findViewById(R.id.bottomMenu);
        Intent intent = getIntent();
        boolean profile = false;


        replaceFragment(new ProdutosFragment());

        bottomNav.setOnItemSelectedListener(item -> {
            Fragment selectedFragment = null;
            int id = item.getItemId();

            if (id == R.id.nav_produto) {
                selectedFragment = new ProdutosFragment();
            }

            else if (id == R.id.nav_cart) {
                selectedFragment = new CarrinhoFragment();
            }

            else if (id == R.id.nav_favorites){
                selectedFragment = new FavoritosFragment();
            }

            else if (id == R.id.criarProduto){
                selectedFragment = new CriarProdutoFragment();
            }

            else if (id == R.id.nav_profile){
                selectedFragment = new ProfileFragment();
            }

            if (selectedFragment != null) {
                replaceFragment(selectedFragment);
            }
            return true;
        });
    }

    private void replaceFragment(Fragment fragment) {
        getSupportFragmentManager().beginTransaction()
                .replace(R.id.container, fragment)
                .commit();
    }


}
