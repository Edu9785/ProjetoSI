package com.example.nexeltools.modelo;

import android.content.Context;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
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
import com.example.nexeltools.listeners.CheckoutListener;
import com.example.nexeltools.listeners.CriarProdutoListener;
import com.example.nexeltools.listeners.EditProfileListener;
import com.example.nexeltools.listeners.EditarProdutoListener;
import com.example.nexeltools.listeners.FaturaListener;
import com.example.nexeltools.listeners.FavoritosListener;
import com.example.nexeltools.listeners.HistoricoListener;
import com.example.nexeltools.listeners.LoginListener;
import com.example.nexeltools.listeners.MetodoexpedicaoListener;
import com.example.nexeltools.listeners.MetodopagamentoListener;
import com.example.nexeltools.listeners.ProdutoListener;
import com.example.nexeltools.listeners.ProdutosListener;
import com.example.nexeltools.listeners.ProfileListener;
import com.example.nexeltools.listeners.RegistarListener;
import com.example.nexeltools.utils.JsonParser;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.ByteArrayOutputStream;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class SingletonAPI {

    private static SingletonAPI instance;
    private LoginListener loginListener;
    private RegistarListener registarListener;
    private ProdutosListener produtosListener;
    private CarrinhoListener carrinhoListener;
    private FavoritosListener favoritosListener;
    private CategoriaListener categoriasListener;
    private MetodopagamentoListener pagamentoListener;
    private MetodoexpedicaoListener expedicaoListener;
    private ProfileListener profileListener;
    private EditProfileListener editProfileListener;
    private HistoricoListener historicoListener;
    private FaturaListener faturaListener;
    private ProdutoListener produtoListener;
    private CheckoutListener checkoutListener;
    private CriarProdutoListener criarProdutoListener;
    private EditarProdutoListener editarProdutoListener;
    private static RequestQueue volleyQueue = null;
    private ArrayList<Produto> produtos = new ArrayList<>();
    private ArrayList<Favorito> favoritos = new ArrayList<>();
    private ArrayList<Categoria> categorias = new ArrayList<>();
    private ArrayList<Metodoexpedicao> expedicoes = new ArrayList<>();
    private ArrayList<Metodopagamento> pagamentos = new ArrayList<>();
    private ArrayList<Produto> produtosvendedor = new ArrayList<>();
    private ArrayList<Produto> produtosvendidos = new ArrayList<>();
    private static final String PREF_NAME = "LoginPreferences";
    private static final String IP_NAME = "SettingsPreferences";
    private static final String KEY_IP = "ip";
    private static final String KEY_TOKEN = "auth_token";
    private int idProfileAtual = 1;

    private SingletonAPI(Context context) {

    }

    public ArrayList<Compra> getComprasOffline(Context context) {
        HistoricoDBHelper dbHelper = new HistoricoDBHelper(context);
        return dbHelper.getComprasProfile(getIdProfileAtual());
    }

    public static synchronized SingletonAPI getInstance(Context context) {
        if (instance == null) {
            instance = new SingletonAPI(context);
            volleyQueue = Volley.newRequestQueue(context);
        }
        return instance;
    }

    public String getLoginUrl(Context context) {
        return "http://" + getIP(context) + "/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/users/login";
    }

    public String getRegistarUrl(Context context) {
        return "http://" + getIP(context) + "/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/users/registar";
    }

    public String getProdutoUrl(Context context) {
        return "http://" + getIP(context) + "/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/produto";
    }

    public String getProdutosUrl(Context context) {
        return "http://" + getIP(context) + "/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/produtos";
    }

    public String getFavoritosUrl(Context context) {
        return "http://" + getIP(context) + "/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/favoritos";
    }

    public String getCarrinhoUrl(Context context) {
        return "http://" + getIP(context) + "/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/carrinhocompras";
    }

    public String getCategoriasUrl(Context context) {
        return "http://" + getIP(context) + "/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/categorias";
    }

    public String getPagamentosUrl(Context context) {
        return "http://" + getIP(context) + "/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/metodopagamentos";
    }

    public String getExpedicoesUrl(Context context) {
        return "http://" + getIP(context) + "/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/metodoexpedicao";
    }

    public String getProfileUrl(Context context) {
        return "http://" + getIP(context) + "/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/profile";
    }

    public String getComprasUrl(Context context) {
        return "http://" + getIP(context) + "/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/compras";
    }

    public String getFaturasUrl(Context context) {
        return "http://" + getIP(context) + "/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/faturas";
    }

    public String getAvaliacoesUrl(Context context) {
        return "http://" + getIP(context) + "/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/avaliacaos";
    }


    public void setIdProfileAtual(int idProfileAtual) {
        this.idProfileAtual = idProfileAtual;
    }

    public int getIdProfileAtual() {
        return idProfileAtual;
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

    public void setHistoricoListener(HistoricoListener historicoListener) {
        this.historicoListener = historicoListener;
    }

    public void setPagamentoListener(MetodopagamentoListener pagamentoListener) {
        this.pagamentoListener = pagamentoListener;
    }

    public void setExpedicaoListener(MetodoexpedicaoListener expedicaoListener) {
        this.expedicaoListener = expedicaoListener;
    }

    public void setFaturaListener(FaturaListener faturaListener) {
        this.faturaListener = faturaListener;
    }

    public void setProdutoListener(ProdutoListener produtoListener) {
        this.produtoListener = produtoListener;
    }

    public void setCheckoutListener(CheckoutListener checkoutListener) {
        this.checkoutListener = checkoutListener;
    }

    public void setCriarProdutoListener(CriarProdutoListener criarProdutoListener) {
        this.criarProdutoListener = criarProdutoListener;
    }

    public void setEditarProdutoListener(EditarProdutoListener editarProdutoListener) {
        this.editarProdutoListener = editarProdutoListener;
    }

    public static String getToken(Context context) {
        SharedPreferences sharedPreferences = context.getSharedPreferences(PREF_NAME, Context.MODE_PRIVATE);
        return sharedPreferences.getString(KEY_TOKEN, null);
    }

    public static String getIP(Context context) {
        SharedPreferences sharedPreferences = context.getSharedPreferences(IP_NAME, Context.MODE_PRIVATE);
        return sharedPreferences.getString(KEY_IP, "172.22.21.215");
    }


    public void loginAPI(final String username, final String password, final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            StringRequest reqLogin = new StringRequest(Request.Method.POST, getLoginUrl(context), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    String token = JsonParser.parserJsonLogin(response);
                    int idUserAtual = JsonParser.parserJsonIdProfile(response);
                    setIdProfileAtual(idUserAtual);
                    if(loginListener != null)
                        loginListener.onLoginSuccess(token);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {

                    if(loginListener != null)
                        loginListener.onLoginFailed();
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
            StringRequest reqRegistar = new StringRequest(Request.Method.POST, getRegistarUrl(context), new Response.Listener<String>() {
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
            JsonArrayRequest reqProdutos = new JsonArrayRequest(Request.Method.GET, getProdutoUrl(context)+"/produtoimagens?access-token="+getToken(context), null, new Response.Listener<JSONArray>() {
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
            StringRequest reqAdicionarFav = new StringRequest(Request.Method.POST, getFavoritosUrl(context)+"/addfavorito/"+id_produto+"?access-token="+getToken(context), new Response.Listener<String>() {
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
            JsonArrayRequest reqFavoritos = new JsonArrayRequest(Request.Method.GET, getFavoritosUrl(context)+"/userfavoritos"+"?access-token="+getToken(context), null, new Response.Listener<JSONArray>() {
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
            StringRequest reqRemoverFav = new StringRequest(Request.Method.DELETE, getFavoritosUrl(context)+"/removerfavorito/"+id_produto+"?access-token="+getToken(context), new Response.Listener<String>() {
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
            JsonObjectRequest reqCarrinho = new JsonObjectRequest(Request.Method.GET, getCarrinhoUrl(context)+"/usercarrinho?access-token="+getToken(context), null, new Response.Listener<JSONObject>() {
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
            StringRequest reqAdicionarCarrinho = new StringRequest(Request.Method.POST, getCarrinhoUrl(context)+"/adicionarproduto/"+id_produto+"?access-token="+getToken(context), new Response.Listener<String>() {
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
            StringRequest reqRemoverCarrinho = new StringRequest(Request.Method.DELETE, getCarrinhoUrl(context)+"/removerproduto/"+id_produto+"?access-token="+getToken(context), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(carrinhoListener != null){
                        carrinhoListener.removerCarrinhoSuccess();
                    }{
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
            JsonArrayRequest reqCategorias = new JsonArrayRequest(Request.Method.GET, getCategoriasUrl(context)+"?access-token="+getToken(context), null, new Response.Listener<JSONArray>() {
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

    public void getPagamentosApi(final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            JsonArrayRequest reqPagamentos = new JsonArrayRequest(Request.Method.GET, getPagamentosUrl(context)+"?access-token="+getToken(context), null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    pagamentos = JsonParser.parserJsonMetodospagamento(response);
                    if(pagamentoListener != null){
                        pagamentoListener.LoadMetodosPagamento(pagamentos);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqPagamentos);
        }
    }

    public void getExpedicoesApi(final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            JsonArrayRequest reqExpedicoes = new JsonArrayRequest(Request.Method.GET, getExpedicoesUrl(context)+"?access-token="+getToken(context), null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    expedicoes = JsonParser.parserJsonMetodosexpedicao(response);
                    if(expedicaoListener != null){
                        expedicaoListener.LoadMetodosExpedicao(expedicoes);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqExpedicoes);
        }
    }

    public void getProfileApi(final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            StringRequest reqProfile = new StringRequest(Request.Method.GET, getProfileUrl(context)+"/userprofile?access-token="+getToken(context), new Response.Listener<String>() {
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
            StringRequest reqEditProfile = new StringRequest(Request.Method.PUT, getProfileUrl(context)+"/editaruserprofile?access-token="+getToken(context), new Response.Listener<String>() {
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
            JsonArrayRequest reqProdutosVendedor = new JsonArrayRequest(Request.Method.GET, getProdutoUrl(context)+"/produtoavender?access-token="+getToken(context), null, new Response.Listener<JSONArray>() {
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
            StringRequest reqRemoverProduto = new StringRequest(Request.Method.DELETE, getProdutosUrl(context)+"/eliminarproduto/"+id_produto+"?access-token="+getToken(context), new Response.Listener<String>() {
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

    public void getProdutosVendidosApi(final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            JsonArrayRequest reqProdutosVendidos = new JsonArrayRequest(Request.Method.GET, getProdutoUrl(context)+"/produtosvendidos?access-token="+getToken(context), null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    produtosvendidos = JsonParser.parserJsonProdutos(response);

                    if(historicoListener != null)
                        historicoListener.onRefreshListaVendas(produtosvendidos);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqProdutosVendidos);
        }
    }

    public void getComprasApi(final Context context) {
        HistoricoDBHelper db = new HistoricoDBHelper(context);

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();

            ArrayList<Compra> comprasBDLocal = db.getComprasProfile(getIdProfileAtual());

            if (historicoListener != null) {
                historicoListener.onRefreshListaCompras(comprasBDLocal);
            }
        } else {
            JsonArrayRequest reqCompras = new JsonArrayRequest(Request.Method.GET, getComprasUrl(context) + "/usercompras?access-token=" + getToken(context), null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    ArrayList<Compra> compras = JsonParser.parserJsonCompras(response);

                    for (Compra compra : compras) {
                        if (db.compraExiste(compra.getId()) == 0) {
                            db.adicionarHistorico(compra);
                        }
                    }

                    if (historicoListener != null) {
                        historicoListener.onRefreshListaCompras(compras);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqCompras);
        }
    }

        public void getAvaliacoesApi(final Context context, int id_vendedor){

            if(!JsonParser.isConnectionInternet(context)){
                Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();

            } else {
                JsonArrayRequest reqAvaliacoes = new JsonArrayRequest(Request.Method.GET, getAvaliacoesUrl(context) + "/vendedoravaliacoes/"+id_vendedor+"?access-token=" + getToken(context), null, new Response.Listener<JSONArray>() {
                    @Override
                    public void onResponse(JSONArray response) {
                        ArrayList<Avaliacao> avaliacoes = JsonParser.parserJsonAvaliacoes(response);

                        if(produtoListener != null) {
                            produtoListener.onRefreshListaAvaliacao(avaliacoes);
                        }
                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    }
                });
                volleyQueue.add(reqAvaliacoes);
            }

        }

    public void getFatura(final Context context, int id_compra){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            JsonObjectRequest reqFatura = new JsonObjectRequest(Request.Method.GET, getFaturasUrl(context)+"/getcomprafatura/"+id_compra+"?access-token="+getToken(context), null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    Fatura fatura = JsonParser.parserJsonFatura(response);
                    if(faturaListener != null){
                        faturaListener.onLoadFatura(fatura);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqFatura);
        }
    }

    public void getProduto(final Context context, int id_produto){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            JsonObjectRequest reqProduto = new JsonObjectRequest(Request.Method.GET, getProdutosUrl(context)+"/produtodetalhes/"+id_produto+"?access-token="+getToken(context), null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    Produto produto = JsonParser.parserJsonProduto(response);
                    if(produtoListener != null){
                        produtoListener.detalhesProduto(produto);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqProduto);
        }
    }

    public void checkoutAPI(final int id_metodopagamento, final int id_metodoexpedicao, final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            StringRequest reqCheckout = new StringRequest(Request.Method.POST, getComprasUrl(context)+"/checkout?access-token="+getToken(context), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(checkoutListener != null)
                        checkoutListener.onCheckoutSuccess();
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
                    params.put("id_metodopagamento", id_metodopagamento+"");
                    params.put("id_metodoexpedicao", id_metodoexpedicao+"");
                    return params;
                }
            };
            volleyQueue.add(reqCheckout);
        }
    }

    public void criarProdutoAPI(final String nome, final String desc, final String preco, final int id_categoria, ArrayList<String> encodedImages, final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            JSONArray jsonArray = new JSONArray();
            for (String encodedImage : encodedImages) {
                jsonArray.put(encodedImage);
            }

            StringRequest reqCriarProduto = new StringRequest(Request.Method.POST, getProdutosUrl(context)+"/criarproduto?access-token="+getToken(context), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(criarProdutoListener != null)
                        criarProdutoListener.onCreateSuccess();
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
                    params.put("nome", nome);
                    params.put("desc", desc);
                    params.put("preco", preco);
                    params.put("id_tipo", id_categoria+"");
                    params.put("imagens", jsonArray.toString());
                    return params;
                }
            };
            volleyQueue.add(reqCriarProduto);
        }
    }


    public void EditarProdutoAPI(final String nome, final String desc, final String preco, final int id_categoria, final int id_produto, ArrayList<String> encodedImages, final Context context){
        if(!JsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        }else{
            JSONArray jsonArray = new JSONArray();
            for (String encodedImage : encodedImages) {
                jsonArray.put(encodedImage);
            }

            StringRequest reqEditarProduto = new StringRequest(Request.Method.PUT, getProdutosUrl(context)+"/editarproduto/"+id_produto+"?access-token="+getToken(context), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(editarProdutoListener != null)
                        editarProdutoListener.onEditSuccess();
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
                    params.put("nome", nome);
                    params.put("desc", desc);
                    params.put("preco", preco);
                    params.put("id_tipo", id_categoria+"");
                    params.put("imagens", jsonArray.toString());
                    return params;
                }
            };
            volleyQueue.add(reqEditarProduto);
        }
    }
}
