package com.example.nexeltools.listeners;

public interface LoginListener {
    void onLoginSuccess(String token);
    void onLoginFailed();
}
