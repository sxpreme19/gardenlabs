package com.example.amsi_project.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import com.example.amsi_project.modelo.Book;
import com.example.amsi_project.modelo.Servico;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class JsonParser {

    //Método parserJsonServico(), que devolve apenas um servico;
    public static Servico parserJsonServico(String response){
        Servico auxServico = null;

        try {
            JSONObject servico = new JSONObject(response);
            int id = servico.getInt("id");
            String titulo = servico.getString("titulo");
            String descricao = servico.getString("descricao");
            int duracao = servico.getInt("duracao");
            double preco = servico.getDouble("preco");
            int prestador_id = servico.getInt("prestador_id");

            auxServico = new Servico(id,titulo,descricao,duracao,preco,prestador_id);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxServico;
    }

    //Método parserJsonServicos(), que devolve a lista de Servicos;
    public static ArrayList<Servico> parserJsonServices(JSONArray response) {
        ArrayList<Servico> services = new ArrayList<>();
        for (int i = 0; i < response.length(); i++) {
            JSONObject service = null;
            try {
                service = (JSONObject) response.get(i);
                int id = service.getInt("id");
                String titulo = service.getString("titulo");
                String descricao = service.getString("descricao");
                int duracao = service.getInt("duracao");
                Double preco = service.getDouble("preco");
                int prestador_id = service.getInt("prestador_id");
                services.add(new Servico(id,titulo,descricao,duracao,preco,prestador_id));
            } catch (JSONException e) {
                throw new RuntimeException(e);
            }

        }
        return services;
    }



    //Método parserJsonLogin(), que efetuará o login na API;
    public static Map<String, Object> parserJsonLogin(String response) {
        String token = null;
        int id;
        Map<String, Object> result = new HashMap<>();
        try {
            JSONObject login = new JSONObject(response);
            token = login.getString("token");
            id = login.getInt("id");
            result.put("token", token);
            result.put("id", id);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return result;
    }

    //Método isConnectionInternet(), que verifica se existe acesso à internet;
    public static boolean isConnectionInternet(Context context){
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();

        return ni != null && ni.isConnected();
    }
}
