package com.example.amsi_project.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.util.Log;

import com.example.amsi_project.modelo.Carrinhoservico;
import com.example.amsi_project.modelo.Fatura;
import com.example.amsi_project.modelo.Favorito;
import com.example.amsi_project.modelo.Linhacarrinhoservico;
import com.example.amsi_project.modelo.Linhafatura;
import com.example.amsi_project.modelo.Metodopagamento;
import com.example.amsi_project.modelo.Servico;
import com.example.amsi_project.modelo.User;
import com.example.amsi_project.modelo.Userprofile;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

public class JsonParser {

    //Method parserJsonUser(), que devolve o userprofile do user logado;
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

    //Method parserJsonUserprofile(), que devolve um userprofile;
    public static Userprofile parserJsonUserprofile(String response){
        Userprofile auxUserprofile = null;

        try {
            JSONObject userprofile = new JSONObject(response);
            int id = userprofile.getInt("id");
            String nome = userprofile.getString("nome");
            String morada = userprofile.getString("morada");
            Integer telefone = userprofile.isNull("telefone") ? null : userprofile.getInt("telefone");
            Integer nif = userprofile.isNull("nif") ? null : userprofile.getInt("nif");
            int user_id = userprofile.getInt("user_id");

            auxUserprofile = new Userprofile(id,nome,morada,telefone,nif,user_id);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxUserprofile;
    }

    //Method parserJsonServico(), que devolve apenas um servico;
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

    //Method parserJsonServicos(), que devolve a lista de Servicos;
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

    //Method parserJsonCart(), que devolve o carrinho do user logado;
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

    //Method parserJsonServico(), que devolve apenas um servico;
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

    //Method parserJsonCartLines(), que devolve as linhas de carrinho do carrinho;
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

    //Method parserJsonFavorito(), que devolve apenas um favorito;
    public static Favorito parserJsonFavorito(String response){
        Favorito auxFavorito = null;

        try {
            JSONObject favorito = new JSONObject(response);
            int id = favorito.getInt("id");
            int userprofile_id = favorito.getInt("userprofile_id");
            int servico_id = favorito.getInt("servico_id");

            auxFavorito = new Favorito(id,userprofile_id,servico_id);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxFavorito;
    }

    //Method parserJsonFavoritos(), que devolve os favoritos do user logado;
    public static ArrayList<Favorito> parserJsonFavoritos(JSONArray response){
        ArrayList<Favorito> favorites = new ArrayList<>();
        for (int i = 0; i < response.length(); i++) {
            JSONObject favorite = null;
            try {
                favorite = (JSONObject) response.get(i);
                int id = favorite.getInt("id");
                int userprofile_id = favorite.getInt("userprofile_id");
                int servico_id = favorite.getInt("servico_id");
                favorites.add(new Favorito(id,userprofile_id,servico_id));
            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }
        return favorites;
    }

    //Method parserJsonFatura(), que devolve apenas uma fatura;
    public static Fatura parserJsonFatura(String response){
        Fatura auxFatura = null;

        try {
            JSONObject fatura = new JSONObject(response);
            int id = fatura.getInt("id");
            double total = fatura.getDouble("total");
            String datahora = fatura.getString("datahora");
            String nome_destinatario = fatura.getString("nome_destinatario");
            String morada_destinatario = fatura.getString("morada_destinatario");
            Integer telefone_destinatario = fatura.getInt("telefone_destinatario");
            Integer nif_destinatario = fatura.getInt("nif_destinatario");
            int metodopagamento_id = fatura.getInt("metodopagamento_id");
            int userprofile_id = fatura.getInt("userprofile_id");

            SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
            Date date;
            try {
                // Parse the date
                date = formatter.parse(datahora);
            } catch (ParseException e) {
                throw new RuntimeException("Error parsing date: " + e.getMessage(), e);
            }

            auxFatura = new Fatura(id,total,date,nome_destinatario,morada_destinatario,telefone_destinatario,nif_destinatario,metodopagamento_id,userprofile_id);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxFatura;
    }

    //Method parserJsonFaturas(), que devolve as faturas do user logado;
    public static ArrayList<Fatura> parserJsonFaturas(JSONArray response){
        ArrayList<Fatura> invoices = new ArrayList<>();
        for (int i = 0; i < response.length(); i++) {
            JSONObject invoice = null;
            try {
                invoice = (JSONObject) response.get(i);
                int id = invoice.getInt("id");
                double total = invoice.getDouble("total");
                String datahora = invoice.getString("datahora");
                String nome_destinatario = invoice.getString("nome_destinatario");
                String morada_destinatario = invoice.getString("morada_destinatario");
                Integer telefone_destinatario = invoice.getInt("telefone_destinatario");
                Integer nif_destinatario = invoice.getInt("nif_destinatario");
                int metodopagamento_id = invoice.getInt("metodopagamento_id");
                int userprofile_id = invoice.getInt("userprofile_id");

                SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
                Date date;
                try {
                    date = formatter.parse(datahora);
                } catch (ParseException e) {
                    throw new RuntimeException("Error parsing date: " + e.getMessage(), e);
                }
                invoices.add(new Fatura(id,total,date,nome_destinatario,morada_destinatario,telefone_destinatario,nif_destinatario,metodopagamento_id,userprofile_id));
            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }
        return invoices;
    }

    //Method parserJsonLinhaFatura(), que devolve apenas uma linha de fatura;
    public static Linhafatura parserJsonLinhaFatura(String response){
        Linhafatura auxLinhafatura = null;

        try {
            JSONObject linhafatura = new JSONObject(response);
            int id = linhafatura.getInt("id");
            int quantidade = linhafatura.getInt("quantidade");
            double precounitario = linhafatura.getDouble("precounitario");
            int fatura_id = linhafatura.getInt("fatura_id");
            int servico_id = linhafatura.getInt("servico_id");

            auxLinhafatura = new Linhafatura(id,quantidade,precounitario,fatura_id,servico_id);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxLinhafatura;
    }

    //Method parserJsonLinhasFatura(), que devolve as linhas de fatura de uma fatura;
    public static ArrayList<Linhafatura> parserJsonLinhasFatura(JSONArray response){
        ArrayList<Linhafatura> invoiceLines = new ArrayList<>();
        for (int i = 0; i < response.length(); i++) {
            JSONObject invoiceLine = null;
            try {
                invoiceLine = (JSONObject) response.get(i);
                int id = invoiceLine.getInt("id");
                double precounitario = invoiceLine.getDouble("precounitario");
                int fatura_id = invoiceLine.getInt("fatura_id");
                int servico_id = invoiceLine.getInt("servico_id");
                invoiceLines.add(new Linhafatura(id,1,precounitario,fatura_id,servico_id));
            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }
        return invoiceLines;
    }

    //Method parserJsonMetodosPagamento(), que devolve os metodos de pagamento existentes;
    public static ArrayList<Metodopagamento> parserJsonMetodosPagamento(JSONArray response){
        ArrayList<Metodopagamento> paymentMethods = new ArrayList<>();
        for (int i = 0; i < response.length(); i++) {
            JSONObject metodopagamento = null;
            try {
                metodopagamento = (JSONObject) response.get(i);
                int id = metodopagamento.getInt("id");
                String descricao = metodopagamento.getString("descricao");
                boolean disponivel = false;

                if (metodopagamento.has("disponivel")) {
                    if (metodopagamento.get("disponivel") instanceof Integer) {
                        disponivel = metodopagamento.getInt("disponivel") == 1;
                    } else if (metodopagamento.get("disponivel") instanceof Boolean) {
                        disponivel = metodopagamento.getBoolean("disponivel");
                    }
                }

                if(disponivel)
                    paymentMethods.add(new Metodopagamento(id,descricao,disponivel));
            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }
        return paymentMethods;
    }

    //Method parserJsonLogin(), que efetuará o login na API;
    public static Map<String, Object> parserJsonLogin(String response) {
        String token,email = null;
        int id,profileid,servicecartid;
        Map<String, Object> result = new HashMap<>();
        try {
            JSONObject login = new JSONObject(response);
            token = login.getString("token");
            email = login.getString("email");
            id = login.getInt("id");
            profileid = login.getInt("profileid");
            servicecartid = login.getInt("servicecartid");
            result.put("token", token);
            result.put("email", email);
            result.put("id", id);
            result.put("profileid",profileid);
            result.put("servicecartid",servicecartid);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return result;
    }

    //Method isConnectionInternet(), que verifica se existe acesso à internet;
    public static boolean isConnectionInternet(Context context){
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();

        return ni != null && ni.isConnected();
    }
}
