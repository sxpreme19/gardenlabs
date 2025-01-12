package com.example.amsi_project.modelo;

import static com.example.amsi_project.utils.JsonParser.parserJsonLogin;

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
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.amsi_project.ListaServicosFragment;
import com.example.amsi_project.listeners.CartLinesListener;
import com.example.amsi_project.listeners.CartListener;
import com.example.amsi_project.listeners.FavoritosListener;
import com.example.amsi_project.listeners.LoginListener;
import com.example.amsi_project.listeners.RegisterListener;
import com.example.amsi_project.listeners.ResetPasswordListener;
import com.example.amsi_project.listeners.ServicoListener;
import com.example.amsi_project.listeners.ServicosListener;
import com.example.amsi_project.listeners.UserListener;
import com.example.amsi_project.listeners.UserProfileListener;
import com.example.amsi_project.utils.JsonParser;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class SingletonGardenLabsManager {

    public BDHelper BD = null;
    private static SingletonGardenLabsManager instance = null;
    private static RequestQueue volleyQueue = null;
    private static String ip = "10.0.2.2";
    public static final String baseURL = "http://"+ip+"/gardenlabs/webapp/backend/web/api/";

    //region ModelVariables
    private User user;
    private Userprofile userprofile;
    private Carrinhoservico cart;
    private ArrayList<Servico> services;
    private ArrayList<Favorito> favoritos;
    private ArrayList<User> users;
    private ArrayList<Linhacarrinhoservico> cartLines;
    //endregion

    //region Listeners

    private UserListener userListener;
    private UserProfileListener userProfileListener;
    private ServicosListener servicosListener;
    private ServicoListener servicoListener;
    private CartListener cartListener;
    private CartLinesListener cartLinesListener;
    private FavoritosListener favoritosListener;
    private LoginListener loginListener;
    private RegisterListener registerListener;
    private ResetPasswordListener resetPasswordListener;

    public void setUserListener(UserListener userListener) {
        this.userListener = userListener;
    }

    public void setUserProfileListener(UserProfileListener userProfileListener) {
        this.userProfileListener = userProfileListener;
    }

    public void setServicosListener(ServicosListener servicosListener) {
        this.servicosListener = servicosListener;
    }

    public void setServicoListener(ServicoListener servicoListener) {
        this.servicoListener = servicoListener;
    }

    public void setCartListener(CartListener cartListener) {
        this.cartListener = cartListener;
    }

    public void setCartLinesListener(CartLinesListener cartLinesListener) {
        this.cartLinesListener = cartLinesListener;
    }

    public void setFavoritosListener(FavoritosListener favoritosListener) {
        this.favoritosListener = favoritosListener;
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
        users = new ArrayList<>();
        BD = new BDHelper(context);
    }

    //region BD-Servicos
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
            BD.removerAllServicosBD();
            for (Servico l : servicos) {
                BD.adicionarServicoBD(l);
            }
        }

        //endregion

    public User getUser(int id) {
        return BD.getUserBD(id);
    }

    public Userprofile getUserProfile(int id) {
        return BD.getUserProfileBD(id);
    }

    public void adicionarLinhasCarrinhoBD(ArrayList<Linhacarrinhoservico> linhascarrinhoservico) {
        for (Linhacarrinhoservico lcs : linhascarrinhoservico) {
            if (!BD.isCartLineExists(lcs.getId())){
                BD.adicionarCartLineBD(lcs);
            }
        }
    }

    public void adicionarFavoritosBD(ArrayList<Favorito> favoritos) {
        for (Favorito favorito : favoritos) {
            if (!BD.isFavoritoExists(favorito.getId())){
                BD.adicionarFavoritoBD(favorito);
            }
        }
    }

    //endregion

    //region Acesso á API
        //region API-Servicos
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

    public void getAllServiceswFiltersAPI(double minPreco,double maxPreco,int minDuracao,int maxDuracao,final Context context) {
        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();

            //Se não tem internet vai buscar todos os livros á bd local
            //Insert, delete and PUT n tem funcionalidades offline
            services = BD.getAllServicosBD();

            if (servicosListener != null) {
                servicosListener.onRefreshListaServicos(services);
            }
        } else {
            JsonArrayRequest reqServices = new JsonArrayRequest(Request.Method.GET, baseURL+"servicos/filter/"+minPreco+"/"+maxPreco+"/"+minDuracao+"/"+maxDuracao+"?access-token="+getTokenFromSharedPreferences(context), null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    services = JsonParser.parserJsonServices(response);

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
        //endregion

        //region API-Users
        public void getUserAPI(final Context context) {
            if (!JsonParser.isConnectionInternet(context)) {
                Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
            } else {
                JsonObjectRequest reqUser = new JsonObjectRequest(Request.Method.GET, baseURL + "users/" + getUserIDFromSharedPreferences(context) + "?access-token=" + getTokenFromSharedPreferences(context), null, new Response.Listener<JSONObject>() {
                            @Override
                            public void onResponse(JSONObject response) {
                                user = JsonParser.parserJsonUser(response);
                                if (!BD.isUserExists(user.getId())) {
                                    BD.adicionarUserBD(user);
                                }
                                if (userListener != null) {
                                    userListener.onRefreshDetalhes(user.getUsername(), user.getEmail());
                                }
                            }
                        },
                        new Response.ErrorListener() {
                            @Override
                            public void onErrorResponse(VolleyError error) {
                                String errorMessage = error.getMessage();
                                if (errorMessage == null || errorMessage.isEmpty()) {
                                    errorMessage = "Error occurred";  // Default message
                                }
                                Toast.makeText(context, errorMessage, Toast.LENGTH_LONG).show();
                            }
                        }
                );
                volleyQueue.add(reqUser); //faz o pedido á API;
            }
        }

        public void editarUserAPI(User user,final Context context) {
            if (!JsonParser.isConnectionInternet(context)) {
                Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
            } else {
                StringRequest reqEditarUser = new StringRequest(Request.Method.PUT, baseURL + "users/" + user.getId() + "?access-token=" + getTokenFromSharedPreferences(context), new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        BD.editarUserBD(user);

                        if (userListener != null) {
                            userListener.onRefreshDetalhes(user.getUsername(),user.getEmail());
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
                        params.put("username", user.getUsername());
                        params.put("email", user.getEmail());
                        return params;
                    }
                };
                volleyQueue.add(reqEditarUser); //faz o pedido á API
            }
        }

        public void removerUserAPI( final Context context) {
            if (!JsonParser.isConnectionInternet(context)) {
                Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
            } else {
                StringRequest reqRemoverUser = new StringRequest(Request.Method.DELETE, baseURL + "users/fulldelete/" + getUserIDFromSharedPreferences(context) + "?access-token=" + getTokenFromSharedPreferences(context), new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        BD.removerUserBD(user.getId());
                        BD.removerUserProfileBD(user.getId());
                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    }
                });
                volleyQueue.add(reqRemoverUser); //faz o pedido á API
            }
        }
        //endregion

        //region API-Userprofiles
        public void getUserProfileAPI(final Context context) {
            if (!JsonParser.isConnectionInternet(context)) {
                Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
            } else {
                StringRequest reqUserprofile = new StringRequest(Request.Method.GET, baseURL+"userprofiles/"+getUserProfileIDFromSharedPreferences(context)+"?access-token="+getTokenFromSharedPreferences(context), new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        userprofile = JsonParser.parserJsonUserprofile(response);
                        if (!BD.isUserProfileExists(userprofile.getId())) { // Assuming isUserProfileExists checks by ID
                            BD.adicionarUserProfileBD(userprofile); // Add to database if it doesn't exist
                        }

                        if (userProfileListener != null) {
                            userProfileListener.onRefreshDetalhes(userprofile.getNome(),userprofile.getMorada(),userprofile.getTelefone(),userprofile.getNif());
                        }

                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    }
                });
                volleyQueue.add(reqUserprofile); //faz o pedido á API;
            }
        }

        public void editarUserProfileAPI(Userprofile userprofile,final Context context) {
        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
        } else {
            StringRequest reqEditarUser = new StringRequest(Request.Method.PUT, baseURL + "userprofiles/" + userprofile.getId() + "?access-token=" + getTokenFromSharedPreferences(context), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    BD.editarUserProfileBD(userprofile);

                    if (userProfileListener != null) {
                        userProfileListener.onRefreshDetalhes(userprofile.getNome(),userprofile.getMorada(),userprofile.getTelefone(),userprofile.getNif());
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
                    params.put("nome", userprofile.getNome());
                    params.put("morada", userprofile.getMorada());
                    params.put("telefone", String.valueOf(userprofile.getTelefone()));
                    params.put("nif", String.valueOf(userprofile.getNif()));

                    return params;
                }
            };
            volleyQueue.add(reqEditarUser); //faz o pedido á API
        }
    }
        //endregion

        //region API-Carts
        public void getCartAPI(final Context context) {
            if (!JsonParser.isConnectionInternet(context)) {
                Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
            } else {
                StringRequest reqUserprofile = new StringRequest(Request.Method.GET, baseURL+"carrinhoservicos/"+getCartIDFromSharedPreferences(context)+"?access-token="+getTokenFromSharedPreferences(context), new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        cart = JsonParser.parserJsonCart(response);
                        if (!BD.isCartExists(cart.getId())) {
                            BD.adicionarCartBD(cart);
                        }
                        if (cart != null) {
                            cartListener.onRefreshDetalhes(cart.getTotal());
                        }

                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    }
                });
                volleyQueue.add(reqUserprofile); //faz o pedido á API;
            }
        }

        public void adicionarCartLineAPI(Servico servico , final Context context) {
            if (!JsonParser.isConnectionInternet(context)) {
                Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
            } else {
                if (BD.isCartLineServicoExists(Integer.parseInt(getCartIDFromSharedPreferences(context)),servico.getId())) {
                    Toast.makeText(context, "Serviço já está no carrinho", Toast.LENGTH_SHORT).show();
                    return;
                }
                StringRequest reqAdicionarLinhaCarrinho = new StringRequest(Request.Method.POST, baseURL+"linhacarrinhoservicos/addtocart?access-token="+getTokenFromSharedPreferences(context), new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                            BD.adicionarCartLineBD(JsonParser.parserJsonCartLine(response));
                            Toast.makeText(context, "Adicionado!", Toast.LENGTH_SHORT).show();
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
                        params.put("preco", String.valueOf(servico.getPreco()));
                        params.put("carrinhoservico_id", getCartIDFromSharedPreferences(context));
                        params.put("servico_id", servico.getId()+ "");
                        return params;
                    }
                };
                volleyQueue.add(reqAdicionarLinhaCarrinho); //faz o pedido á API
            }
        }

        public void getCartLinesAPI(final Context context) {
            if (!JsonParser.isConnectionInternet(context)) {
                Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
            } else {
                JsonArrayRequest reqCartlines = new JsonArrayRequest(Request.Method.GET, baseURL+"linhacarrinhoservicos/carrinhoservico_id/"+getCartIDFromSharedPreferences(context)+"?access-token="+getTokenFromSharedPreferences(context), null, new Response.Listener<JSONArray>() {
                    @Override
                    public void onResponse(JSONArray response) {
                        cartLines = JsonParser.parserJsonCartLines(response);
                        adicionarLinhasCarrinhoBD(cartLines);

                        if (cartLinesListener != null) {
                            cartLinesListener.onRefreshListaLinhasCarrinho(cartLines);
                        }

                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    }
                });
                volleyQueue.add(reqCartlines); //faz o pedido á API;
            }
        }

        public void removerCartLineAPI(final Linhacarrinhoservico linhacarrinhoservico, final Context context) {
            if (!JsonParser.isConnectionInternet(context)) {
                Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
            } else {
                StringRequest reqRemoverLinhacarrinhoservico = new StringRequest(Request.Method.DELETE, baseURL + "linhacarrinhoservicos/removefromcart/" + linhacarrinhoservico.getId() + "?access-token=" + getTokenFromSharedPreferences(context), new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        BD.removerCartLineBD(linhacarrinhoservico.getId());
                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    }
                });
                volleyQueue.add(reqRemoverLinhacarrinhoservico); //faz o pedido á API
            }
        }
        //endregion

        //region API-Favoritos
        public void adicionarFavoritoAPI(Servico servico , final Context context) {
                if (!JsonParser.isConnectionInternet(context)) {
                    Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
                } else {
                    if (BD.isFavoritoServicoExists(Integer.parseInt(getUserProfileIDFromSharedPreferences(context)),servico.getId())) {
                        Toast.makeText(context, "Serviço já está na wishlist", Toast.LENGTH_SHORT).show();
                        return;
                    }
                    StringRequest reqAdicionarFavorito = new StringRequest(Request.Method.POST, baseURL+"favoritos?access-token="+getTokenFromSharedPreferences(context), new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            BD.adicionarFavoritoBD(JsonParser.parserJsonFavorito(response));
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
                            params.put("userprofile_id", getUserProfileIDFromSharedPreferences(context));
                            params.put("servico_id", servico.getId()+ "");
                            return params;
                        }
                    };
                    volleyQueue.add(reqAdicionarFavorito); //faz o pedido á API
                }
            }
        public void getFavoritosAPI(final Context context) {
            if (!JsonParser.isConnectionInternet(context)) {
                Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
            } else {
                JsonArrayRequest reqFavoritos = new JsonArrayRequest(Request.Method.GET, baseURL+"favoritos/userprofile_id/"+getUserProfileIDFromSharedPreferences(context)+"?access-token="+getTokenFromSharedPreferences(context), null, new Response.Listener<JSONArray>() {
                    @Override
                    public void onResponse(JSONArray response) {
                        favoritos = JsonParser.parserJsonFavoritos(response);
                        adicionarFavoritosBD(favoritos);

                        if (favoritosListener != null) {
                            favoritosListener.onRefreshListaFavoritos(favoritos);
                        }

                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    }
                });
                volleyQueue.add(reqFavoritos); //faz o pedido á API;
            }
        }
        public void removerFavoritoAPI(final Favorito favorito, final Context context) {
            if (!JsonParser.isConnectionInternet(context)) {
                Toast.makeText(context, "Não tem ligação á internet", Toast.LENGTH_LONG).show();
            } else {
                StringRequest reqRemoverFavorito = new StringRequest(Request.Method.DELETE, baseURL + "favoritos/" + favorito.getId() + "?access-token=" + getTokenFromSharedPreferences(context), new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        BD.removerFavoritoBD(favorito.getId());
                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    }
                });
                volleyQueue.add(reqRemoverFavorito); //faz o pedido á API
            }
        }
        //endregion
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
                    int profileid = (int) loginResponse.get("profileid");
                    int servicecartid = (int) loginResponse.get("servicecartid");
                    if (loginListener != null) {
                        loginListener.onUpdateLogin(id,token,username,profileid,servicecartid);
                    }
                    Toast.makeText(context, "Login válido!", Toast.LENGTH_LONG).show();
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    String errorMessage = "An unexpected error occurred.";
                    Toast.makeText(context, errorMessage, Toast.LENGTH_LONG).show();
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

    //region SharedData

    public String getTokenFromSharedPreferences(Context context) {
        SharedPreferences sharedPref = context.getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        return sharedPref.getString("token", null);  // Return the token, or null if not found
    }

    public String getUserProfileIDFromSharedPreferences(Context context) {
        SharedPreferences sharedPref = context.getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        int userprofileID = sharedPref.getInt("profileid", -1); // Retrieve the user ID as Integer
        return Integer.toString(userprofileID); // Return the token, or null if not found
    }

    public String getUserIDFromSharedPreferences(Context context) {
        SharedPreferences sharedPref = context.getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        int userID = sharedPref.getInt("id", -1); // Retrieve the user ID as Integer
        return Integer.toString(userID);
    }

    public String getCartIDFromSharedPreferences(Context context) {
        SharedPreferences sharedPref = context.getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        int userID = sharedPref.getInt("servicecartid", -1); // Retrieve the user ID as Integer
        return Integer.toString(userID);
    }

    //endregion

}
