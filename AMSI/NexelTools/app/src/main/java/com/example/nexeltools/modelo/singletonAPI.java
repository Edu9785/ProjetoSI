package com.example.nexeltools.modelo;

import android.content.Context;
import android.content.SharedPreferences;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.nexeltools.listeners.LoginListener;
import com.example.nexeltools.listeners.ProdutosListener;
import com.example.nexeltools.listeners.RegistarListener;
import com.example.nexeltools.utils.JsonParser;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class singletonAPI {

    private static singletonAPI instance;
    private static final String LOGIN_URL = "http://192.168.1.153/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/users/login";
    private static final String Registar_URL = "http://192.168.1.153/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/users/registar";
    private static final String PRODUTOS_URL = "http://192.168.1.153/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/produto/produtoimagens";
    private LoginListener loginListener;
    private RegistarListener registarListener;
    private ProdutosListener produtosListener;
    private static RequestQueue volleyQueue = null;
    private ArrayList<Produto> produtos = new ArrayList<>();
    private static final String PREF_NAME = "LoginPreferences";
    private static final String KEY_TOKEN = "auth_token";

    private singletonAPI(Context context) {

    }

    public static synchronized singletonAPI getInstance(Context context) {
        if (instance == null) {
            instance = new singletonAPI(context);
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

    public void setProdutosListener(ProdutosListener produtosListener) {
        this.produtosListener = produtosListener;
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
            JsonArrayRequest reqProdutos = new JsonArrayRequest(Request.Method.GET, PRODUTOS_URL+"?access-token="+getToken(context), null, new Response.Listener<JSONArray>() {
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
}
