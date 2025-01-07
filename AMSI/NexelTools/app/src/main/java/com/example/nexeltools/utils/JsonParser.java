package com.example.nexeltools.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import com.example.nexeltools.modelo.Produto;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class JsonParser {

    public static String parserJsonLogin(String response){
        String token = null;
        try {
            JSONObject login = new JSONObject(response);
            token = login.getString("token");
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return token;
    }

    public static ArrayList<Produto> parserJsonProdutos(JSONArray response) {
        ArrayList<Produto> produtos = new ArrayList<>();

        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject jsonProduto = response.getJSONObject(i);

                int id = jsonProduto.getInt("id");
                String desc = jsonProduto.getString("desc");
                double preco = jsonProduto.getDouble("preco");
                String nome = jsonProduto.getString("nome");
                String vendedor = jsonProduto.getString("vendedor");
                int estado = jsonProduto.getInt("estado");
                int id_tipo = jsonProduto.getInt("id_tipo");

                ArrayList<String> imagens = new ArrayList<>();
                JSONArray jsonImagens = jsonProduto.getJSONArray("imagens");
                for (int j = 0; j < jsonImagens.length(); j++) {
                    imagens.add(jsonImagens.getString(j));
                }

                Produto produto = new Produto(id, desc, preco, nome, vendedor, estado, id_tipo, imagens);
                produtos.add(produto);

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }

        return produtos;
    }


    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = cm.getActiveNetworkInfo();
        return networkInfo != null && networkInfo.isConnected();
    }
}
