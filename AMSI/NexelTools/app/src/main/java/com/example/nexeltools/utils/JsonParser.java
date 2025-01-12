package com.example.nexeltools.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import com.example.nexeltools.modelo.Carrinho;
import com.example.nexeltools.modelo.Categoria;
import com.example.nexeltools.modelo.Favorito;
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

    public static String parserJsonAddFavorito(String response){
        String message = null;
        try {
            JSONObject addFavorito = new JSONObject(response);
            message = addFavorito.getString("message");
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return message;
    }


    public static ArrayList<Favorito> parserJsonFavoritos(JSONArray response) {
        ArrayList<Favorito> favoritos = new ArrayList<>();

        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject jsonFavorito = response.getJSONObject(i);

                int id = jsonFavorito.getInt("id");
                int id_user = jsonFavorito.getInt("id_user");
                int id_produto = jsonFavorito.getInt("id_produto");
                double preco = jsonFavorito.getDouble("preco");
                String nome = jsonFavorito.getString("nome");
                String vendedor = jsonFavorito.getString("vendedor");

                ArrayList<String> imagens = new ArrayList<>();
                JSONArray jsonImagens = jsonFavorito.getJSONArray("imagens");
                for (int j = 0; j < jsonImagens.length(); j++) {
                    imagens.add(jsonImagens.getString(j));
                }

                Favorito favorito = new Favorito(id, id_user, id_produto, preco, nome, vendedor, imagens);
                favoritos.add(favorito);

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }

        return favoritos;
    }

    public static Carrinho parserJsonCarrinho(JSONObject response) {
        Carrinho carrinho = null;

        try {
            int idCarrinho = response.getInt("id");
            int idProfile = response.getInt("id_profile");
            double precoTotal = response.getDouble("precototal");

            JSONArray jsonProdutos = response.getJSONArray("produtos");
            ArrayList<Produto> produtosCarrinho = new ArrayList<>();

            for (int i = 0; i < jsonProdutos.length(); i++) {
                JSONObject jsonProduto = jsonProdutos.getJSONObject(i);

                int id = jsonProduto.getInt("id_produto");
                String nome = jsonProduto.getString("nome");
                String desc = jsonProduto.getString("desc");
                double preco = jsonProduto.getDouble("preco");
                String vendedor = jsonProduto.getString("vendedor");
                int estado = jsonProduto.getInt("estado");
                int id_tipo = jsonProduto.getInt("id_tipo");

                ArrayList<String> imagens = new ArrayList<>();

                JSONArray jsonImagens = jsonProduto.getJSONArray("imagens");
                for (int j = 0; j < jsonImagens.length(); j++) {
                    imagens.add(jsonImagens.getString(j));
                }

                Produto produto = new Produto(id, desc, preco, nome, vendedor, estado, id_tipo, imagens);
                produtosCarrinho.add(produto);
            }

            carrinho = new Carrinho(idCarrinho, idProfile, produtosCarrinho, precoTotal);

        } catch (JSONException e) {
            e.printStackTrace();
        }

        return carrinho;
    }

    public static String parserJsonAddCarrinho(String response){
        String message = null;
        try {
            JSONObject addCarrinho = new JSONObject(response);
            message = addCarrinho.getString("message");
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return message;
    }

    public static ArrayList<Categoria> parserJsonCategorias(JSONArray response) {
        ArrayList<Categoria> categorias = new ArrayList<>();

        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject jsonCategoria = response.getJSONObject(i);

                int id = jsonCategoria.getInt("id");
                String nome = jsonCategoria.getString("tipo");

                Categoria categoria = new Categoria(id, nome);
                categorias.add(categoria);

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }

        return categorias;
    }


    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = cm.getActiveNetworkInfo();
        return networkInfo != null && networkInfo.isConnected();
    }


}
