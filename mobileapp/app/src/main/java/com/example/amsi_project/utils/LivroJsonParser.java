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

public class LivroJsonParser {

    //Método parserJsonLivro(), que devolve apenas um livro;
    public static Book parserJsonLivro(String response){
        Book auxLivro = null;

        try {
            JSONObject livro = new JSONObject(response);
            int id = livro.getInt("id");
            String titulo = livro.getString("titulo");
            String serie = livro.getString("serie");
            String autor = livro.getString("autor");
            int ano = livro.getInt("ano");
            String capa = livro.getString("capa");

            auxLivro = new Book(id,capa,ano,titulo,serie,autor);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxLivro;
    }


    //Método parserJsonLivros(), que devolve a lista de livros;
    public static ArrayList<Book> parserJsonLivros(JSONArray response) {
        ArrayList<Book> livros = new ArrayList<>();
        for (int i = 0; i < response.length(); i++) {
            JSONObject livro = null;
            try {
                livro = (JSONObject) response.get(i);
                int id = livro.getInt("id");
                String titulo = livro.getString("titulo");
                String serie = livro.getString("serie");
                String autor = livro.getString("autor");
                int ano = livro.getInt("ano");
                String capa = livro.getString("capa");
                livros.add(new Book(id, capa, ano, titulo, serie, autor));
            } catch (JSONException e) {
                throw new RuntimeException(e);
            }

        }
        return livros;
    }

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

    //Método isConnectionInternet(), que verifica se existe acesso à internet;
    public static boolean isConnectionInternet(Context context){
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();

        return ni != null && ni.isConnected();
    }
}
