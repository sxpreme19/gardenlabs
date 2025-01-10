package com.example.amsi_project.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.util.Log;

import com.example.amsi_project.modelo.Carrinhoservico;
import com.example.amsi_project.modelo.Linhacarrinhoservico;
import com.example.amsi_project.modelo.Servico;
import com.example.amsi_project.modelo.User;
import com.example.amsi_project.modelo.Userprofile;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class JsonParser {

    //Método parserJsonUser(), que devolve o userprofile do user logado;
    public static User parserJsonUser(JSONObject response){
        User auxUser = null;

        try {
            int id = response.getInt("id");
            String username = response.getString("username");
            String auth_key = response.getString("auth_key");
            String password_hash = response.getString("password_hash");
            String password_reset_token = response.getString("password_reset_token");
            String email = response.getString("email");
            int status = response.getInt("status");
            int created_at = response.getInt("created_at");
            int updated_at = response.getInt("updated_at");
            String verification_token = response.getString("verification_token");

            auxUser = new User(id,username,auth_key,password_hash,password_reset_token,email,status,created_at,updated_at,verification_token);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxUser;
    }

    //Método parserJsonUserprofile(), que devolve um userprofile;
    public static Userprofile parserJsonUserprofile(String response){
        Userprofile auxUserprofile = null;

        try {
            JSONObject userprofile = new JSONObject(response);
            int id = userprofile.getInt("id");
            String nome = userprofile.getString("nome");
            String morada = userprofile.getString("morada");
            int telefone = userprofile.getInt("telefone");
            int nif = userprofile.getInt("nif");
            int user_id = userprofile.getInt("user_id");

            auxUserprofile = new Userprofile(id,nome,morada,telefone,nif,user_id);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxUserprofile;
    }

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


    //Método parserJsonCart(), que devolve o carrinho do user logado;
    public static Carrinhoservico parserJsonCart(String response){
        Carrinhoservico auxCarrinhoservico = null;

        try {
            JSONObject cart = new JSONObject(response);
            int id = cart.getInt("id");
            double total = cart.getDouble("total");
            int userprofile_id = cart.getInt("userprofile_id");

            auxCarrinhoservico = new Carrinhoservico(id,total,userprofile_id);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxCarrinhoservico;
    }

    //Método parserJsonServico(), que devolve apenas um servico;
    public static Linhacarrinhoservico parserJsonCartLine(String response){
        Linhacarrinhoservico auxLinhacarrinhoservico = null;

        try {
            JSONObject linhacarrinhoservico = new JSONObject(response);
            int id = linhacarrinhoservico.getInt("id");
            int carrinhoservico_id = linhacarrinhoservico.getInt("carrinhoservico_id");
            double preco = linhacarrinhoservico.getDouble("preco");
            int servico_id = linhacarrinhoservico.getInt("servico_id");

            auxLinhacarrinhoservico = new Linhacarrinhoservico(id,preco,carrinhoservico_id,servico_id);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxLinhacarrinhoservico;
    }

    //Método parserJsonCartLines(), que devolve as linhas de carrinho do carrinho do user logado;
    public static ArrayList<Linhacarrinhoservico> parserJsonCartLines(JSONArray response){
        ArrayList<Linhacarrinhoservico> cartLines = new ArrayList<>();
        for (int i = 0; i < response.length(); i++) {
            JSONObject cartLine = null;
            try {
                cartLine = (JSONObject) response.get(i);
                int id = cartLine.getInt("id");
                Double preco = cartLine.getDouble("preco");
                int carrinhoservico_id = cartLine.getInt("carrinhoservico_id");
                int servico_id = cartLine.getInt("servico_id");
                cartLines.add(new Linhacarrinhoservico(id,preco,carrinhoservico_id,servico_id));
            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }
        return cartLines;
    }


    //Método parserJsonLogin(), que efetuará o login na API;
    public static Map<String, Object> parserJsonLogin(String response) {
        String token = null;
        int id,profileid,servicecartid;
        Map<String, Object> result = new HashMap<>();
        try {
            JSONObject login = new JSONObject(response);
            token = login.getString("token");
            id = login.getInt("id");
            profileid = login.getInt("profileid");
            servicecartid = login.getInt("servicecartid");
            result.put("token", token);
            result.put("id", id);
            result.put("profileid",profileid);
            result.put("servicecartid",servicecartid);
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
