package com.example.nexeltools.modelo;

import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.nexeltools.listeners.LoginListener;
import com.example.nexeltools.utils.JsonParser;

import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class singletonAPI {

    private static singletonAPI instance;
    private static final String LOGIN_URL = "http://192.168.1.69/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/users/login";
    private static final String TOKEN = "TOKEN";
    private LoginListener loginListener;
    private static RequestQueue volleyQueue = null;

    private singletonAPI(Context context) {
        volleyQueue = Volley.newRequestQueue(context);
    }

    public static synchronized singletonAPI getInstance(Context context) {
        if (instance == null) {
            instance = new singletonAPI(context);
        }
        return instance;
    }

    public void setLoginListener(LoginListener listener) {
        this.loginListener = listener;
    }

    public void loginAPI(final String username, final String password, final Context context) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à Internet", Toast.LENGTH_LONG).show();
            return;
        }

        StringRequest reqLogin = new StringRequest(Request.Method.POST, LOGIN_URL, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    // Parser para pegar o token da resposta da API
                    String token = JsonParser.parserJsonLogin(response);

                    if (token != null && !token.isEmpty()) {
                        // Salva o token no SharedPreferences
                        saveToken(context, token);
                        if (loginListener != null) {
                            loginListener.onLoginSuccess(token);
                        }
                    } else {
                        if (loginListener != null) {
                            loginListener.onLoginFailure("Token não encontrado");
                        }
                    }
                } catch (Exception e) {
                    Log.e("Login", "Erro ao processar resposta: " + e.getMessage());
                    if (loginListener != null) {
                        loginListener.onLoginFailure("Erro ao processar resposta");
                    }
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                String errorMessage = "Erro desconhecido ao tentar realizar login";
                if (error.networkResponse != null && error.networkResponse.data != null) {
                    try {
                        String responseBody = new String(error.networkResponse.data, "UTF-8");
                        JSONObject errorObj = new JSONObject(responseBody);
                        errorMessage = errorObj.optString("message", errorMessage);
                    } catch (Exception e) {
                        Log.e("LoginError", "Erro ao parsear erro: " + e.getMessage());
                    }
                }
                Log.e("LoginError", errorMessage);
                Toast.makeText(context, errorMessage, Toast.LENGTH_LONG).show();
                if (loginListener != null) {
                    loginListener.onLoginFailure(errorMessage);
                }
            }
        }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("username", username);
                params.put("password", password);
                return params;
            }
        };

        volleyQueue.add(reqLogin);
    }

    private void saveToken(Context context, String token) {
        SharedPreferences sharedPreferences = context.getSharedPreferences("AppPrefs", Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putString(TOKEN, token);
        editor.apply();
    }

}
