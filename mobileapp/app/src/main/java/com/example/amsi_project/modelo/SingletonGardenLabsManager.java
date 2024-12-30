package com.example.amsi_project.modelo;

import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;
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
import com.example.amsi_project.ListaLivrosFragment;
import com.example.amsi_project.listeners.LivroListener;
import com.example.amsi_project.listeners.LivrosListener;
import com.example.amsi_project.listeners.LoginListener;
import com.example.amsi_project.listeners.RegisterListener;
import com.example.amsi_project.utils.LivroJsonParser;

import org.json.JSONArray;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class SingletonGardenLabsManager {
    private ArrayList<Book> books;
    private static SingletonGardenLabsManager instance = null;
    public LivroBDHelper LivrosBD = null;
    private static RequestQueue volleyQueue = null;

    //fora da escola -> Uso da VPN(usar o ip em vez do nome)
    public static final String mUrlAPILivros = "http://172.22.21.41/api/livros";
    public static final String mUrlAPILogin = "http://10.0.2.2/gardenlabs/webapp/backend/web/api/user/login";
    public static final String mUrlAPIRegister = "http://10.0.2.2/gardenlabs/webapp/backend/web/api/user/register";

    private LivrosListener livrosListener;
    private LivroListener livroListener;
    private LoginListener loginListener;
    private RegisterListener registerListener;

    public static synchronized SingletonGardenLabsManager getInstance(Context context) {
        if (instance == null) {
            instance = new SingletonGardenLabsManager(context);
            volleyQueue = Volley.newRequestQueue(context);
        }
        return instance;
    }

    private SingletonGardenLabsManager(Context context) {
        books = new ArrayList<>();
        LivrosBD = new LivroBDHelper(context);
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

    /*
    private void gerarDadosDinamicos() {
        books = new ArrayList<>();

        Book B = new Book(1,2019, R.drawable.programarandroid2, "Programar android em AMSI", "Android Saga", "Equipa de AMSI");
        books.add(B);

        books.add(new Book(R.drawable.programarandroid2, 2024, "Programar em Android AMSI - 1", "2ª Temporada", "AMSI TEAM"));
        books.add(new Book(R.d
        rawable.programarandroid1, 2024, "Programar em Android AMSI - 2", "2ª Temporada", "AMSI TEAM"));
        books.add(new Book(R.drawable.eminem, 2024, "Mom's Spaguetti - 3", "Slim Shady", "EMINEM"));
        books.add(new Book(R.drawable.programarandroid2, 2024, "Programar em Android AMSI - 4", "2ª Temporada", "AMSI TEAM"));
        books.add(new Book(R.drawable.programarandroid1, 2024, "Programar em Android AMSI - 5", "2ª Temporada", "AMSI TEAM"));
        books.add(new Book(R.drawable.eminem, 2024, "Mom's Spaguetti - 6", "Slim Shady", "EMINEM"));
        books.add(new Book(R.drawable.programarandroid2, 2024, "Programar em Android AMSI - 7", "2ª Temporada", "AMSI TEAM"));
        books.add(new Book(R.drawable.programarandroid1, 2024, "Programar em Android AMSI - 8", "2ª Temporada", "AMSI TEAM"));
        books.add(new Book(R.drawable.eminem, 2024, "Mom's Spaguetti - 9", "Slim Shady", "EMINEM"));
        books.add(new Book(R.drawable.programarandroid2, 2024, "Programar em Android AMSI - 10", "2ª Temporada", "AMSI TEAM"));
    }*/

    public ArrayList<Book> getBooksBD() {
        books = LivrosBD.getAllLivrosBD();
        return new ArrayList<>(books);
    }

    public Book getBook(int id) {
        for (Book l : books) {
            if (l.getId() == id)
                return l;
        }
        return null;
    }

    public void addBookBD(Book book) {
        LivrosBD.adicionarLivroBD(book);
        //books.add(auxLivro);
    }

    public void deleteBookBD(int id) {
        Book l = getBook(id);
        if (l != null) {
            if (LivrosBD.removerLivroBD(id))
                books.remove(l);
        }
    }

    public void editBookBD(Book book) {
        Book l = getBook(book.getId());
        if (l != null) {
            LivrosBD.editarLivroBD(book);
        }
    }

    public void adicionarLivrosBD(ArrayList<Book> livros) {
        //apagar os livros tds e adicionar os livros atuais da api
        LivrosBD.removerAllLivrosBD();
        for (Book l : livros) {
            LivrosBD.adicionarLivroBD(l);
        }
    }


    //region Acesso á API

    public void getAllLivrosAPI(final Context context) {
        if (!LivroJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();

            //Se não tem internet vai buscar todos os livros á bd local
            //Insert, delete and PUT n tem funcionalidades offline
            books = LivrosBD.getAllLivrosBD();

            if (livrosListener != null) {
                livrosListener.onRefreshListaLivros(books);
            }
        } else {
            JsonArrayRequest reqLivros = new JsonArrayRequest(Request.Method.GET, mUrlAPILivros, null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    books = LivroJsonParser.parserJsonLivros(response);
                    adicionarLivrosBD(books);

                    if (livrosListener != null) {
                        livrosListener.onRefreshListaLivros(books);
                    }

                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqLivros); //faz o pedido á API;
        }
    }

    public void adicionarLivroAPI(final Book livro, final Context context) {
        if (!LivroJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
        } else {
            StringRequest reqAdicionarLivro = new StringRequest(Request.Method.POST, mUrlAPILivros, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    LivrosBD.adicionarLivroBD(LivroJsonParser.parserJsonLivro(response));

                    if (livroListener != null) {
                        livroListener.onRefreshDetalhes(ListaLivrosFragment.ADD);
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
        if (!LivroJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
        } else {
            StringRequest reqRemoverLivro = new StringRequest(Request.Method.DELETE, mUrlAPILivros + '/' + livro.getId(), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    LivrosBD.removerLivroBD(livro.getId());

                    if (livroListener != null) {
                        livroListener.onRefreshDetalhes(ListaLivrosFragment.DELETE);
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

    public void editarLivroAPI(final Book livro, final Context context) {
        if (!LivroJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
        } else {
            StringRequest reqEditarLivro = new StringRequest(Request.Method.PUT, mUrlAPILivros + '/' + livro.getId(), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    LivrosBD.editarLivroBD(livro);

                    if (livroListener != null) {
                        livroListener.onRefreshDetalhes(ListaLivrosFragment.EDIT);
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


    //region Acceso do login e register da API

    public void loginAPI(final Context context, final String username, final String password) {
        if (!LivroJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem Ligação á internet", Toast.LENGTH_LONG).show();
        } else {
            StringRequest reqLogin = new StringRequest(Request.Method.POST, mUrlAPILogin, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    //parse da response para obter o token
                    String token = LivroJsonParser.parserJsonLogin(response);
                    //informar a vista- descomentar quando tier o login listener
                    if (loginListener != null) {
                        loginListener.onUpdateLogin(token,username);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Log.d("LoginAPI", "Sending parameters: username=" + username + ", password=" + password);
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
        if (!LivroJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem Ligação á internet", Toast.LENGTH_LONG).show();
        } else {
            StringRequest reqLogin = new StringRequest(Request.Method.POST, mUrlAPIRegister, new Response.Listener<String>() {
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

    //endregion

    public String getTokenFromSharedPreferences(Context context) {
        SharedPreferences sharedPref = context.getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        return sharedPref.getString("token", null);  // Return the token, or null if not found
    }

}
