package com.example.amsi_project.modelo;

import static com.example.amsi_project.utils.JsonParser.parserJsonLogin;

import android.content.Context;
import android.content.SharedPreferences;
import android.widget.Toast;

import androidx.annotation.Nullable;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.amsi_project.DetalhesLivroActivity;
import com.example.amsi_project.ListaServicosFragment;
import com.example.amsi_project.listeners.LivroListener;
import com.example.amsi_project.listeners.LivrosListener;
import com.example.amsi_project.listeners.LoginListener;
import com.example.amsi_project.listeners.RegisterListener;
import com.example.amsi_project.listeners.ResetPasswordListener;
import com.example.amsi_project.listeners.ServicosListener;
import com.example.amsi_project.utils.JsonParser;

import org.json.JSONArray;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class SingletonGardenLabsManager {

    public BDHelper BD = null;
    private ArrayList<Servico> services;
    private static SingletonGardenLabsManager instance = null;
    private static RequestQueue volleyQueue = null;
    public static final String mUrlAPILivros = "http://172.22.21.41/api/livros";
    public static final String baseURL = "http://10.0.2.2/gardenlabs/webapp/backend/web/api/";

    //region Listeners

    private ServicosListener servicosListener;
    private LivrosListener livrosListener;
    private LivroListener livroListener;
    private LoginListener loginListener;
    private RegisterListener registerListener;
    private ResetPasswordListener resetPasswordListener;


    public void setServicosListener(ServicosListener servicosListener) {
        this.servicosListener = servicosListener;
    }
    public void setLivrosListener(LivrosListener livrosListener) {
        this.livrosListener = livrosListener;
    }

    public void setLivroListener(LivroListener livroListener) {
        this.livroListener = livroListener;
    }

    public void setLoginListener(LoginListener loginListener) {
        this.loginListener = loginListener;
    }

    public void setRegisterListener(RegisterListener registerListener) {
        this.registerListener = registerListener;
    }

    public void setResetPasswordListener(ResetPasswordListener resetPasswordListener) {
        this.resetPasswordListener = resetPasswordListener;
    }

    //endregion

    public static synchronized SingletonGardenLabsManager getInstance(Context context) {
        if (instance == null) {
            instance = new SingletonGardenLabsManager(context);
            volleyQueue = Volley.newRequestQueue(context);
        }
        return instance;
    }

    //region Acesso á BD

    private SingletonGardenLabsManager(Context context) {
        services = new ArrayList<>();
        BD = new BDHelper(context);
    }

    public ArrayList<Servico> getServicosBD() {
        services = BD.getAllServicosBD();
        return new ArrayList<>(services);
    }

    public Servico getServico(int id) {
        for (Servico l : services) {
            if (l.getId() == id)
                return l;
        }
        return null;
    }

    public void addServicoBD(Servico servico) {
        BD.adicionarServicoBD(servico);
        //books.add(auxLivro);
    }

    public void deleteServicoBD(int id) {
        Servico l = getServico(id);
        if (l != null) {
            if (BD.removerServicoBD(id))
                services.remove(l);
        }
    }

    public void editServicoBD(Servico servico) {
        Servico l = getServico(servico.getId());
        if (l != null) {
            BD.editarServicoBD(servico);
        }
    }

    public void adicionarServicosBD(ArrayList<Servico> servicos) {
        //apagar os livros tds e adicionar os livros atuais da api
        BD.removerAllServicosBD();
        for (Servico l : servicos) {
            BD.adicionarServicoBD(l);
        }
    }
    //endregion

    //region Acesso á API

    public void getAllServicesAPI(final Context context) {
        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();

            //Se não tem internet vai buscar todos os livros á bd local
            //Insert, delete and PUT n tem funcionalidades offline
            services = BD.getAllServicosBD();

            if (servicosListener != null) {
                servicosListener.onRefreshListaServicos(services);
            }
        } else {
            JsonArrayRequest reqServices = new JsonArrayRequest(Request.Method.GET, baseURL+"servico?access-token="+getTokenFromSharedPreferences(context), null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    services = JsonParser.parserJsonServices(response);
                    adicionarServicosBD(services);

                    if (servicosListener != null) {
                        servicosListener.onRefreshListaServicos(services);
                    }

                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqServices); //faz o pedido á API;
        }
    }

    public void adicionarServicoAPI(final Book livro, final Context context) {
        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
        } else {
            StringRequest reqAdicionarLivro = new StringRequest(Request.Method.POST, mUrlAPILivros, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    BD.adicionarServicoBD(JsonParser.parserJsonServico(response));

                    if (livroListener != null) {
                        livroListener.onRefreshDetalhes(ListaServicosFragment.ADD);
                    }

                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            }) {
                @Nullable
                @Override
                protected Map<String, String> getParams() throws AuthFailureError {
                    Map<String, String> params = new HashMap<>();

                    params.put("token", getTokenFromSharedPreferences(context));
                    params.put("titulo", livro.getTitulo());
                    params.put("serie", livro.getSerie());
                    params.put("autor", livro.getAutor());
                    params.put("ano", livro.getAno() + "");
                    params.put("capa", livro.getCapa() == null ? DetalhesLivroActivity.DEFAULT_IMG : livro.getCapa());
                    return params;
                }
            };
            volleyQueue.add(reqAdicionarLivro); //faz o pedido á API
        }
    }

    public void removerLivroAPI(final Book livro, final Context context) {
        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
        } else {
            StringRequest reqRemoverLivro = new StringRequest(Request.Method.DELETE, mUrlAPILivros + '/' + livro.getId(), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    BD.removerServicoBD(livro.getId());

                    if (livroListener != null) {
                        livroListener.onRefreshDetalhes(ListaServicosFragment.DELETE);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqRemoverLivro); //faz o pedido á API
        }
    }

    public void editarServicoAPI(final Book livro, final Context context) {
        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
        } else {
            StringRequest reqEditarLivro = new StringRequest(Request.Method.PUT, mUrlAPILivros + '/' + livro.getId(), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    BD.editarServicoBD(livro);

                    if (livroListener != null) {
                        livroListener.onRefreshDetalhes(ListaServicosFragment.EDIT);
                    }

                    //TODO: Informar a vista
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            }) {
                @Nullable
                @Override
                protected Map<String, String> getParams() throws AuthFailureError {
                    Map<String, String> params = new HashMap<>();
                    params.put("token", getTokenFromSharedPreferences(context));
                    params.put("titulo", livro.getTitulo());
                    params.put("serie", livro.getSerie());
                    params.put("autor", livro.getAutor());
                    params.put("ano", livro.getAno() + "");
                    params.put("capa", livro.getCapa() == null ? DetalhesLivroActivity.DEFAULT_IMG : livro.getCapa());
                    return params;
                }
            };
            volleyQueue.add(reqEditarLivro); //faz o pedido á API
        }
    }


    //endregion


    //region Acesso do login e register da API

    public void loginAPI(final Context context, final String username, final String password) {
        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem Ligação á internet", Toast.LENGTH_LONG).show();
        } else {
            StringRequest reqLogin = new StringRequest(Request.Method.POST, baseURL+"user/login", new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Map<String, Object> loginResponse = parserJsonLogin(response);
                    String token = (String) loginResponse.get("token");
                    int id = (int) loginResponse.get("id");
                    if (loginListener != null) {
                        loginListener.onUpdateLogin(id,token,username);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            }) {
                @Nullable
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

    public void registerAPI(final Context context, final String username, final String password,final String email) {
        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem Ligação á internet", Toast.LENGTH_LONG).show();
        } else {
            StringRequest reqLogin = new StringRequest(Request.Method.POST, baseURL+"user/register", new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(registerListener != null){
                        registerListener.onUpdateRegister();
                    }
                    Toast.makeText(context,"Registered!", Toast.LENGTH_LONG).show();
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            }) {
                @Nullable
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<>();
                    params.put("username", username);
                    params.put("password", password);
                    params.put("email", email);
                    return params;
                }
            };
            volleyQueue.add(reqLogin);
        }
    }

    public void resetpasswordAPI(final Context context, final String email,final String oldpassword,final String newpassword) {
        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem Ligação á internet", Toast.LENGTH_LONG).show();
        } else {
            StringRequest reqLogin = new StringRequest(Request.Method.POST, baseURL+"user/reset-password", new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(resetPasswordListener != null){
                        resetPasswordListener.onUpdateResetPassword();
                    }
                    Toast.makeText(context,"Password reseted!", Toast.LENGTH_LONG).show();
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            }) {
                @Nullable
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<>();
                    params.put("email", email);
                    params.put("oldpassword", oldpassword);
                    params.put("newpassword", newpassword);
                    return params;
                }
            };
            volleyQueue.add(reqLogin);
        }
    }

    //endregion

    public String getTokenFromSharedPreferences(Context context) {
        SharedPreferences sharedPref = context.getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        return sharedPref.getString("token", null);  // Return the token, or null if not found
    }

}
