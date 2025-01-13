package com.example.nexeltools.modelo;

import android.content.Context;
import android.content.SharedPreferences;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.nexeltools.listeners.CarrinhoListener;
import com.example.nexeltools.listeners.CategoriaListener;
import com.example.nexeltools.listeners.EditProfileListener;
import com.example.nexeltools.listeners.FavoritosListener;
import com.example.nexeltools.listeners.LoginListener;
import com.example.nexeltools.listeners.ProdutosListener;
import com.example.nexeltools.listeners.ProfileListener;
import com.example.nexeltools.listeners.RegistarListener;
import com.example.nexeltools.utils.JsonParser;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class SingletonAPI {

    private static SingletonAPI instance;
    private static final String LOGIN_URL = "http://192.168.1.153/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/users/login";
    private static final String Registar_URL = "http://192.168.1.153/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/users/registar";
    private static final String PRODUTO_URL = "http://192.168.1.153/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/produto";
    private static final String PRODUTOS_URL = "http://192.168.1.153/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/produtos";
    private static final String FAVORITOS_URL = "http://192.168.1.153/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/favoritos";
    private static final String CARRINHO_URL = "http://192.168.1.153/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/carrinhocompras";
    private static final String CATEGORIAS_URL = "http://192.168.1.153/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/categorias";
    private static final String PROFILE_URL = "http://192.168.1.153/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/profile";
    private LoginListener loginListener;
    private RegistarListener registarListener;
    private ProdutosListener produtosListener;
    private CarrinhoListener carrinhoListener;
    private FavoritosListener favoritosListener;
    private CategoriaListener categoriasListener;
    private ProfileListener profileListener;
    private EditProfileListener editProfileListener;
    private static RequestQueue volleyQueue = null;
    private ArrayList<Produto> produtos = new ArrayList<>();
    private ArrayList<Favorito> favoritos = new ArrayList<>();
    private ArrayList<Categoria> categorias = new ArrayList<>();
    private ArrayList<Produto> produtosvendedor = new ArrayList<>();
    private static final String PREF_NAME = "LoginPreferences";
    private static final String KEY_TOKEN = "auth_token";

    private SingletonAPI(Context context) {

    }

    public static synchronized SingletonAPI getInstance(Context context) {
        if (instance == null) {
            instance = new SingletonAPI(context);
            volleyQueue = Volley.newRequestQueue(context);
        }
        return instance;
    }

    public void setLoginListener(LoginListener loginlistener) {
        this.loginListener = loginlistener;
    }

    public void setRegistarListener(RegistarListener registarListener) {
        this.registarListener = registarListener;
    }

    public void setFavoritosListener(FavoritosListener favoritosListener) {
        this.favoritosListener = favoritosListener;
    }


    public void setProdutosListener(ProdutosListener produtosListener) {
        this.produtosListener = produtosListener;
    }

    public void setCarrinhoListener(CarrinhoListener carrinhoListener) {
        this.carrinhoListener = carrinhoListener;
    }

    public void setCategoriaListener(CategoriaListener categoriasListener) {
        this.categoriasListener = categoriasListener;
    }

    public void setProfileListener(ProfileListener profileListener) {
        this.profileListener = profileListener;
    }


    public void setEditProfileListener(EditProfileListener editProfileListener) {
        this.editProfileListener = editProfileListener;
    }


    public static String getToken(Context context) {
        SharedPreferences sharedPreferences = context.getSharedPreferences(PREF_NAME, Context.MODE_PRIVATE);
        return sharedPreferences.getString(KEY_TOKEN, null);
    }



    public void loginAPI(final String username, final String password, final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            StringRequest reqLogin = new StringRequest(Request.Method.POST, LOGIN_URL, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    String token = JsonParser.parserJsonLogin(response);
                    if(loginListener != null)
                        loginListener.onLoginSuccess(token);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            })
            {
                @Override
                protected Map<String, String> getParams() {

                    Map <String, String> params = new HashMap<>();
                    params.put("username", username);
                    params.put("password", password);
                    return params;
                }
            };
            volleyQueue.add(reqLogin);
        }
    }

    public void registarAPI(final String username, final String password, final String email, final String nome, final String nif, final String telemovel, final String morada, final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            StringRequest reqRegistar = new StringRequest(Request.Method.POST, Registar_URL, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(registarListener != null)
                        registarListener.onRegistarSuccess();
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            })
            {
                @Override
                protected Map<String, String> getParams() {

                    Map <String, String> params = new HashMap<>();
                    params.put("username", username);
                    params.put("email", email);
                    params.put("password", password);
                    params.put("nome", nome);
                    params.put("nif", nif);
                    params.put("telemovel", telemovel);
                    params.put("morada", morada);
                    return params;
                }
            };
            volleyQueue.add(reqRegistar);
        }
    }

    public void getAllProdutosApi(final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            JsonArrayRequest reqProdutos = new JsonArrayRequest(Request.Method.GET, PRODUTO_URL+"/produtoimagens?access-token="+getToken(context), null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    produtos = JsonParser.parserJsonProdutos(response);

                    if(produtosListener != null)
                        produtosListener.onRefreshListaProdutos(produtos);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqProdutos);
        }
    }

    public void addFavoritoApi(final Context context, final int id_produto){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            StringRequest reqAdicionarFav = new StringRequest(Request.Method.POST, FAVORITOS_URL+"/addfavorito/"+id_produto+"?access-token="+getToken(context), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    String message = JsonParser.parserJsonAddFavorito(response);
                    if(produtosListener != null){
                        produtosListener.onAddFavoritoSuccess(message);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqAdicionarFav);
        }
    }

    public void getAllFavoritosApi(final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            JsonArrayRequest reqFavoritos = new JsonArrayRequest(Request.Method.GET, FAVORITOS_URL+"/userfavoritos"+"?access-token="+getToken(context), null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    favoritos = JsonParser.parserJsonFavoritos(response);

                    if(favoritosListener != null)
                        favoritosListener.onRefreshListaFavoritos(favoritos);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqFavoritos);
        }
    }


    public void RemoverFavoritoApi(final Context context, final int id_produto){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            StringRequest reqRemoverFav = new StringRequest(Request.Method.DELETE, FAVORITOS_URL+"/removerfavorito/"+id_produto+"?access-token="+getToken(context), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(favoritosListener != null){
                        favoritosListener.onRemoveFavoritoSuccess();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqRemoverFav);
        }
    }

    public void getCarrinho(final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            JsonObjectRequest reqCarrinho = new JsonObjectRequest(Request.Method.GET, CARRINHO_URL+"/usercarrinho?access-token="+getToken(context), null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    Carrinho carrinho = JsonParser.parserJsonCarrinho(response);
                    if(carrinhoListener != null){
                        carrinhoListener.onRefreshListaCarrinho(carrinho);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqCarrinho);
        }
    }

    public void addCarrinhoApi(final Context context, final int id_produto, final boolean isFavorito){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            StringRequest reqAdicionarCarrinho = new StringRequest(Request.Method.POST, CARRINHO_URL+"/adicionarproduto/"+id_produto+"?access-token="+getToken(context), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    String message = JsonParser.parserJsonAddCarrinho(response);

                    if (isFavorito) {
                        if (favoritosListener != null) {
                            favoritosListener.onAddCarrinhoSuccess(message);
                        }
                    } else {
                        if (produtosListener != null) {
                            produtosListener.onAddCarrinhoSuccess(message);
                        }
                    }

                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqAdicionarCarrinho);
        }
    }

    public void RemoverCarrinhoApi(final Context context, final int id_produto){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            StringRequest reqRemoverCarrinho = new StringRequest(Request.Method.DELETE, CARRINHO_URL+"/removerproduto/"+id_produto+"?access-token="+getToken(context), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(carrinhoListener != null){
                        carrinhoListener.removerCarrinhoSuccess();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqRemoverCarrinho);
        }
    }

    public void getCategoriasApi(final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            JsonArrayRequest reqCategorias = new JsonArrayRequest(Request.Method.GET, CATEGORIAS_URL+"?access-token="+getToken(context), null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    categorias = JsonParser.parserJsonCategorias(response);
                    if(categoriasListener != null){
                        categoriasListener.LoadCategorias(categorias);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqCategorias);
        }
    }

    public void getProfileApi(final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            StringRequest reqProfile = new StringRequest(Request.Method.GET, PROFILE_URL+"/userprofile?access-token="+getToken(context), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Profile profile = JsonParser.parserJsonProfile(response);
                    if(profileListener != null){
                        profileListener.onLoadProfile(profile);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqProfile);
        }
    }

    public void editProfileAPI(final String username, final String email, final String nome, final String nif, final String telemovel, final String morada, final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            StringRequest reqEditProfile = new StringRequest(Request.Method.PUT, PROFILE_URL+"/editaruserprofile?access-token="+getToken(context), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(editProfileListener != null)
                        editProfileListener.editProfileSucess();
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            })
            {
                @Override
                protected Map<String, String> getParams() {

                    Map <String, String> params = new HashMap<>();
                    params.put("username", username);
                    params.put("email", email);
                    params.put("nome", nome);
                    params.put("nif", nif);
                    params.put("telemovel", telemovel);
                    params.put("morada", morada);
                    return params;
                }
            };
            volleyQueue.add(reqEditProfile);
        }
    }

    public void getProdutosVendedorApi(final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            JsonArrayRequest reqProdutosVendedor = new JsonArrayRequest(Request.Method.GET, PRODUTO_URL+"/produtoavender?access-token="+getToken(context), null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    produtosvendedor = JsonParser.parserJsonProdutosVendedor(response);

                    if(profileListener != null)
                        profileListener.onRefreshListaProdutosVendedor(produtosvendedor);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqProdutosVendedor);
        }
    }

    public void RemoverProdutoApi(final Context context, final int id_produto){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            StringRequest reqRemoverProduto = new StringRequest(Request.Method.DELETE, PRODUTOS_URL+"/eliminarproduto/"+id_produto+"?access-token="+getToken(context), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(profileListener != null){
                        profileListener.onDeleteProductSuccess();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqRemoverProduto);
        }
    }
}
