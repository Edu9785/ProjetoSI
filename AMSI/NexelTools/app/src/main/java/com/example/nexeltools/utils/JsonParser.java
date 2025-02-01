package com.example.nexeltools.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import com.example.nexeltools.modelo.Avaliacao;
import com.example.nexeltools.modelo.Carrinho;
import com.example.nexeltools.modelo.Categoria;
import com.example.nexeltools.modelo.Compra;
import com.example.nexeltools.modelo.Fatura;
import com.example.nexeltools.modelo.Favorito;
import com.example.nexeltools.modelo.Metodoexpedicao;
import com.example.nexeltools.modelo.Metodopagamento;
import com.example.nexeltools.modelo.Produto;
import com.example.nexeltools.modelo.Profile;

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

    public static int parserJsonIdProfile(String response){
        int id = 0;
        try {
            JSONObject login = new JSONObject(response);
            id = login.getInt("id_profile");
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return id;
    }

    public static ArrayList<Produto> parserJsonProdutos(JSONArray response) {
        ArrayList<Produto> produtos = new ArrayList<>();

        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject jsonProduto = response.getJSONObject(i);

                int id = jsonProduto.getInt("id");
                int id_vendedor = jsonProduto.getInt("id_vendedor");
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

                Produto produto = new Produto(id, desc, preco, nome, vendedor, estado, id_vendedor, id_tipo, imagens, 0);
                produtos.add(produto);

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }

        return produtos;
    }

    public static int parserJsonProdutosCount(JSONArray response) {
        int produtos = 0;

        for (int i = 0; i < response.length(); i++) {
            produtos++;
        }

        return produtos;
    }

    public static double parserJsonProdutoMaisCaro(JSONArray response) {
        ArrayList<Produto> produtos = new ArrayList<Produto>();

        double mais_alto = 0;
        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject jsonProduto = response.getJSONObject(i);

                if(jsonProduto.getInt("preco") > mais_alto){
                    mais_alto = jsonProduto.getDouble("preco");
                }
            } catch (JSONException e) {
                throw new RuntimeException(e);
            }

        }

        return mais_alto;
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

                Produto produto = new Produto(id, desc, preco, nome, vendedor, estado, 0, id_tipo, imagens, 0);
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

    public static ArrayList<Metodoexpedicao> parserJsonMetodosexpedicao(JSONArray response) {
        ArrayList<Metodoexpedicao> metodosexpedicao = new ArrayList<>();

        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject jsonExpedicao = response.getJSONObject(i);

                int id = jsonExpedicao.getInt("id");
                String nome = jsonExpedicao.getString("nome");
                double preco = jsonExpedicao.getDouble("preco");

                Metodoexpedicao metodo = new Metodoexpedicao(id, nome, preco);
                metodosexpedicao.add(metodo);

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }

        return metodosexpedicao;
    }

    public static ArrayList<Metodopagamento> parserJsonMetodospagamento(JSONArray response) {
        ArrayList<Metodopagamento> pagamentos = new ArrayList<>();

        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject jsonPagamento = response.getJSONObject(i);

                int id = jsonPagamento.getInt("id");
                String nome = jsonPagamento.getString("nomemetodo");

                Metodopagamento pagamento = new Metodopagamento(id, nome);
                pagamentos.add(pagamento);

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }

        return pagamentos;
    }

    public static Profile parserJsonProfile(String response) {
        Profile userprofile = null;
         try {
                JSONObject jsonProfile = new JSONObject(response);
                int id = jsonProfile.getInt("id");
                String username = jsonProfile.getString("username");
                double avaliacao = jsonProfile.getDouble("avaliacao");
                String nome = jsonProfile.getString("nome");
                String morada = jsonProfile.getString("morada");
                String email = jsonProfile.getString("email");
                int telemovel = jsonProfile.getInt("telemovel");
                int nif = jsonProfile.getInt("nif");


                userprofile = new Profile(id, nif, telemovel, avaliacao, username, email, morada, nome);



            } catch (JSONException e) {
                throw new RuntimeException(e);
            }

        return userprofile;
    }

    public static ArrayList<Produto> parserJsonProdutosVendedor(JSONArray response) {
        ArrayList<Produto> produtosvendedor = new ArrayList<>();

        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject jsonProdutoVendedor = response.getJSONObject(i);

                int id = jsonProdutoVendedor.getInt("id");
                String desc = jsonProdutoVendedor.getString("desc");
                double preco = jsonProdutoVendedor.getDouble("preco");
                String nome = jsonProdutoVendedor.getString("nome");
                String vendedor = jsonProdutoVendedor.getString("vendedor");
                int estado = jsonProdutoVendedor.getInt("estado");
                int id_tipo = jsonProdutoVendedor.getInt("id_tipo");

                ArrayList<String> imagens = new ArrayList<>();
                JSONArray jsonImagens = jsonProdutoVendedor.getJSONArray("imagens");
                for (int j = 0; j < jsonImagens.length(); j++) {
                    imagens.add(jsonImagens.getString(j));
                }

                Produto produto = new Produto(id, desc, preco, nome, vendedor, estado, 0, id_tipo, imagens, 0);
                produtosvendedor.add(produto);

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }

        return produtosvendedor;
    }

    public static ArrayList<Compra> parserJsonCompras(JSONArray response) {
        ArrayList<Compra> compras = new ArrayList<>();

        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject jsonCompra = response.getJSONObject(i);

                int id = jsonCompra.getInt("id");
                double precototal = jsonCompra.getDouble("precototal");
                String metodoexpedicao = jsonCompra.getString("metodoexpedicao");
                String metodopagamento = jsonCompra.getString("metodopagamento");
                String datacompra = jsonCompra.getString("datacompra");
                int id_profile = jsonCompra.getInt("id_profile");

                ArrayList<Produto> produtos = new ArrayList<>();
                JSONArray jsonProdutos = jsonCompra.getJSONArray("produtos");

                for (int j = 0; j < jsonProdutos.length(); j++) {
                    JSONObject jsonProduto = jsonProdutos.getJSONObject(j);

                    int id_produto = jsonProduto.getInt("id_produto");
                    String nome = jsonProduto.getString("nome");
                    double preco = jsonProduto.getDouble("preco");
                    String vendedor = jsonProduto.getString("vendedor");
                    int estado = jsonProduto.getInt("estado");

                    Produto produto = new Produto(id_produto, null, preco, nome, vendedor, estado, 0, 0, null, 0);
                    produtos.add(produto);
                }

                Compra compra = new Compra(id, precototal, metodoexpedicao, metodopagamento, datacompra, id_profile, produtos);
                compras.add(compra);

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }

        return compras;
    }

    public static ArrayList<Avaliacao> parserJsonAvaliacoes(JSONArray response) {
        ArrayList<Avaliacao> avaliacoes = new ArrayList<>();

        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject jsonAvaliacao = response.getJSONObject(i);

                int id = jsonAvaliacao.getInt("id");
                double rating = jsonAvaliacao.getDouble("avaliacao");
                String comentario = jsonAvaliacao.getString("comentario");
                String username = jsonAvaliacao.getString("username");

                Avaliacao avaliacao = new Avaliacao(id, rating, comentario, username);
                avaliacoes.add(avaliacao);

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }

        return avaliacoes;
    }

    public static Fatura parserJsonFatura(JSONObject response) {
        Fatura fatura = null;

        try {
            int id = response.getInt("id");
            String datahora = response.getString("datahora");
            double precofatura = response.getDouble("precofatura");
            double expedicaopreco = response.getDouble("metodoexpedicaopreco");
            String expedicaonome = response.getString("metodoexpedicaonome");
            String comprador = response.getString("comprador");

            JSONArray jsonProdutos = response.getJSONArray("linhasfatura");
            ArrayList<Produto> linhasfatura = new ArrayList<>();

            for (int i = 0; i < jsonProdutos.length(); i++) {
                JSONObject jsonProduto = jsonProdutos.getJSONObject(i);

                int id_produto = jsonProduto.getInt("id_produto");
                String nome = jsonProduto.getString("nome");
                double preco = jsonProduto.getDouble("preco");
                String vendedor = jsonProduto.getString("vendedor");


                Produto produto = new Produto(id_produto, null, preco, nome, vendedor, 0, 0, 0, null, 0);
                linhasfatura.add(produto);
            }

            fatura = new Fatura(id, linhasfatura, precofatura, expedicaopreco, datahora, comprador, expedicaonome);

        } catch (JSONException e) {
            e.printStackTrace();
        }

        return fatura;
    }


    public static Produto parserJsonProduto(JSONObject response) {
       Produto produto = null;

            try {
                int id = response.getInt("id");
                int id_vendedor = response.getInt("id_vendedor");
                String desc = response.getString("desc");
                double preco = response.getDouble("preco");
                String nome = response.getString("nome");
                String vendedor = response.getString("vendedor");
                double avaliacao = response.getDouble("avaliacao");

                ArrayList<String> imagens = new ArrayList<>();
                JSONArray jsonImagens = response.getJSONArray("imagens");
                for (int j = 0; j < jsonImagens.length(); j++) {
                    imagens.add(jsonImagens.getString(j));
                }

                produto = new Produto(id, desc, preco, nome, vendedor, 0, id_vendedor,0, imagens, avaliacao);

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }

        return produto;
    }


    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = cm.getActiveNetworkInfo();
        return networkInfo != null && networkInfo.isConnected();
    }


}
