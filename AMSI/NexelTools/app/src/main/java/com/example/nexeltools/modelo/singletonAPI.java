package com.example.nexeltools.modelo;

import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.example.nexeltools.listeners.LoginListener;
import com.example.nexeltools.utils.JsonParser;
import com.android.volley.toolbox.Volley;

import java.util.HashMap;
import java.util.Map;

public class singletonAPI {

    private static singletonAPI instance;
    private static final String USER_URL = "http://192.168.1.69/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/users";
    private static final String LOGIN_URL = "http://192.168.1.69/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/users/login";
    private static final String TOKEN = "TOKEN";
    private LoginListener loginListener;
    private com.android.volley.RequestQueue volleyQueue;

    private singletonAPI(Context context) {
        volleyQueue = Volley.newRequestQueue(context);
    }

    public static synchronized singletonAPI getInstance(Context context) {
        if (instance == null) {
            instance = new singletonAPI(context);
        }
        return instance;
    }

    public void setLoginListener(LoginListener loginListener) {
        this.loginListener = loginListener;
    }

    public void loginAPI(final String username, final String password, final Context context) {
        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação a Internet", Toast.LENGTH_LONG).show();
        } else {
            StringRequest reqLogin = new StringRequest(Request.Method.POST, LOGIN_URL, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    String token = JsonParser.parserJsonLogin(response);

                    SharedPreferences sharedPreferences = context.getSharedPreferences("AppPrefs", Context.MODE_PRIVATE);
                    SharedPreferences.Editor editor = sharedPreferences.edit();
                    editor.putString(TOKEN, token);
                    editor.apply();

                    if (loginListener != null) {
                        loginListener.onLoginSuccess(token);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Log.e("LoginError", "Erro no login: " + error.getMessage());
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
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
    }
}
