package com.example.nexeltools;

import android.util.Log;

import org.json.JSONObject;

import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Scanner;

public class singletonAPI {

    private static singletonAPI instance;
    private static final String USER_URL = "http://192.168.1.95/NexelTools/PLSI_SIS/NexelTools_WebApp/backend/web/api/users";


    private singletonAPI() {

    }

    public static singletonAPI getInstance() {
        if (instance == null) {
            synchronized (singletonAPI.class) {
                if (instance == null) {
                    instance = new singletonAPI();
                }
            }
        }
        return instance;
    }

    public String login(String username, String password) {
        try {
            URL url = new URL(USER_URL + "/login");
            HttpURLConnection connection = (HttpURLConnection) url.openConnection();

            connection.setRequestMethod("POST");
            connection.setRequestProperty("Content-Type", "application/json");
            connection.setDoOutput(true);

            JSONObject jsonRequest = new JSONObject();
            jsonRequest.put("username", username);
            jsonRequest.put("password", password);

            Log.d("entrei", "entrei");

            try (OutputStream os = connection.getOutputStream()) {
                byte[] input = jsonRequest.toString().getBytes("utf-8");
                os.write(input, 0, input.length);
            }

            int responseCode = connection.getResponseCode();
            if (responseCode == HttpURLConnection.HTTP_OK) {
                try (Scanner scanner = new Scanner(connection.getInputStream())) {
                    StringBuilder response = new StringBuilder();
                    while (scanner.hasNextLine()) {
                        response.append(scanner.nextLine());
                    }
                    Log.d("LoginResponse", response.toString());
                    return parseToken(response.toString());
                }
            } else {
                System.out.println("Erro: Código de resposta " + responseCode);
                try (Scanner scanner = new Scanner(connection.getErrorStream())) {
                    while (scanner.hasNextLine()) {
                        System.out.println(scanner.nextLine());
                    }
                }
                return null;
            }
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    private String parseToken(String response) {
        if (response.contains("\"token\"")) {
            int start = response.indexOf("\"token\":\"") + 9;
            int end = response.indexOf("\"", start);
            return response.substring(start, end);
        }
        return null;
    }
}
