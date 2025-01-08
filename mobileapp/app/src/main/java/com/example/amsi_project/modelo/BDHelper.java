package com.example.amsi_project.modelo;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

import androidx.annotation.Nullable;

import java.util.ArrayList;

public class BDHelper extends SQLiteOpenHelper {

    //Nome da base de dados
    private static final String DB_NAME = "bdGardenLabs";

    //region Tabelas
    private static final String SERVICOS = "Servicos";
    private static final String USERS = "Users";
    private static final String USERPROFILES = "Userprofiles";
    private static final String CARRINHOSSERVICOS = "Carrinhosservicos";
    private static final String LINHACARRINHOSERVICOS = "Linhacarrinhoservicos";
    private static final String FAVORITOS = "Favoritos";
    private static final String REVIEWS = "Reviews";
    private static final String FATURAS = "Faturas";
    private static final String LINHAFATURA = "Linhafatura";
    private static final String METODOPAGAMENTOS = "Metodopagamento";
    //endregion

    //region Variables
    private static final String  ID ="id",STATUS="status",CREATED_AT="created_at",UPDATED_AT="updated_at",USER_ID="user_id",NIF="nif",TELEFONE="telefone",USERPROFILE_ID="userprofile_id",CARRINHOSERVICO_ID="carrinhoservico_id",SERVICO_ID="servico_id";
    private static final String TITULO = "titulo", DESCRICAO ="descricao", DURACAO ="duracao", PRECO ="PRECO", PRESTADOR_ID ="prestador_id";
    private static final String USERNAME ="username",AUTH_KEY="auth_key",PASSWORD_HASH="password_hash",PASSWORD_RESET_TOKEN="password_reset_token",EMAIL="email",VERIFICATION_TOKEN="verification_token";
    private static final String NOME ="nome",MORADA ="morada";
    private static final String TOTAL="total";
    //endregion
    private final SQLiteDatabase db;


    public BDHelper(@Nullable Context context) {
        super(context, DB_NAME, null, 1);
        this.db = getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        String sqlCriarTabelaServicos = "CREATE TABLE " + SERVICOS + "(" +
                ID + " INTEGER PRIMARY KEY, "+
                TITULO + " TEXT NOT NULL, " +
                DESCRICAO + " TEXT NOT NULL, " +
                DURACAO + " INTEGER NOT NULL, " +
                PRECO + " DOUBLE NOT NULL, " +
                PRESTADOR_ID + " INTEGER NOT NULL " +
                ");";

        String sqlCriarTabelaUsers = "CREATE TABLE " + USERS + "(" +
                ID + " INTEGER PRIMARY KEY, "+
                USERNAME + " TEXT NOT NULL, " +
                AUTH_KEY + " TEXT NOT NULL, " +
                PASSWORD_HASH + " TEXT NOT NULL, " +
                PASSWORD_RESET_TOKEN + " TEXT NOT NULL, " +
                EMAIL + " TEXT NOT NULL, " +
                STATUS + " INTEGER NOT NULL, " +
                CREATED_AT + " INTEGER NOT NULL, " +
                UPDATED_AT + " INTEGER NOT NULL, " +
                VERIFICATION_TOKEN + " TEXT NOT NULL " +
                ");";

        String sqlCriarTabelaUserprofiles = "CREATE TABLE " + USERPROFILES + "(" +
                ID + " INTEGER PRIMARY KEY, "+
                MORADA + " TEXT NOT NULL, " +
                NIF + " TEXT NOT NULL, " +
                TELEFONE + " TEXT NOT NULL, " +
                NOME + " TEXT NOT NULL, " +
                USER_ID + " INTEGER NOT NULL " +
                ");";

        String sqlCriarTabelaCarrinhoservico = "CREATE TABLE " + CARRINHOSSERVICOS + "(" +
                ID + " INTEGER PRIMARY KEY, "+
                TOTAL + " DOUBLE NOT NULL, " +
                USERPROFILE_ID + " INTEGER NOT NULL " +
                ");";

        String sqlCriarTabelaLinhacarrinhoservicos = "CREATE TABLE " + LINHACARRINHOSERVICOS + "(" +
                ID + " INTEGER PRIMARY KEY, "+
                PRECO + " DOUBLE NOT NULL, " +
                CARRINHOSERVICO_ID + " INTEGER NOT NULL " +
                SERVICO_ID + " INTEGER NOT NULL " +
                ");";

        String sqlCriarTabelaFavoritos = "CREATE TABLE " + FAVORITOS + "(" +
                ID + " INTEGER PRIMARY KEY, "+
                USERPROFILE_ID + " INTEGER NOT NULL " +
                SERVICO_ID + " INTEGER NOT NULL " +
                ");";

        try {
            sqLiteDatabase.execSQL(sqlCriarTabelaServicos);
            sqLiteDatabase.execSQL(sqlCriarTabelaUsers);
            sqLiteDatabase.execSQL(sqlCriarTabelaUserprofiles);
            sqLiteDatabase.execSQL(sqlCriarTabelaCarrinhoservico);
            sqLiteDatabase.execSQL(sqlCriarTabelaLinhacarrinhoservicos);
            sqLiteDatabase.execSQL(sqlCriarTabelaFavoritos);
            Log.d("BDHelper", "Tables created successfully.");
        } catch (Exception e) {
            Log.e("BDHelper", "Error creating tables: " + e.getMessage());
        }
    }

    @Override
    public void onUpgrade(SQLiteDatabase sqLiteDatabase, int i, int i1) {
        //Apagar tabelas e criar de novo
        String sqlDeleteTabelaServicos = "DROP TABLE IF EXISTS " + SERVICOS;
        String sqlDeleteTabelaUsers = "DROP TABLE IF EXISTS " + USERS;
        String sqlDeleteTabelaUserprofiles = "DROP TABLE IF EXISTS " + USERPROFILES;
        sqLiteDatabase.execSQL(sqlDeleteTabelaServicos);
        sqLiteDatabase.execSQL(sqlDeleteTabelaUsers);
        sqLiteDatabase.execSQL(sqlDeleteTabelaUserprofiles);

        onCreate(sqLiteDatabase);
    }


    //region CRUD Servicos
    public Servico adicionarServicoBD(Servico s){
        ContentValues values = new ContentValues();
        values.put(ID,s.getId());
        values.put(TITULO,s.getTitulo());
        values.put(DESCRICAO,s.getDescricao());
        values.put(DURACAO,s.getDuracao());
        values.put(PRECO,s.getPreco());
        values.put(PRESTADOR_ID,s.getPrestador_id());

        long id = this.db.insert(SERVICOS, null,values);

        if(id > -1) {
            s.setId((int) id);
            return s;
        }

        return null;
    }

    public boolean editarServicoBD(Servico s){
        ContentValues values = new ContentValues();
        values.put(TITULO,s.getTitulo());
        values.put(DESCRICAO,s.getDescricao());
        values.put(DURACAO,s.getDuracao());
        values.put(PRECO,s.getPreco());
        values.put(PRESTADOR_ID,s.getPrestador_id());

        int nLinhas = this.db.update(SERVICOS, values ,ID + "=?", new String[]{s.getId() + ""});

        return nLinhas == 1;
    }

    public boolean removerServicoBD(int id){
        int nLinhas = this.db.delete(SERVICOS, ID + "=?", new String[]{id + ""});
        return nLinhas == 1;
    }

    public void removerAllServicosBD(){
        this.db.delete(SERVICOS,null, null);
    }

    public ArrayList<Servico> getAllServicosBD(){

        ArrayList<Servico> Servicos = new ArrayList<>();

        Cursor cursor = this.db.query(SERVICOS, new String[]{ID, TITULO, DESCRICAO, DURACAO, PRECO, PRESTADOR_ID},null, null,null, null, null);

        if(cursor.moveToFirst()){
            do{
                Servico aux = new Servico(cursor.getInt(0),cursor.getString(1),cursor.getString(2), cursor.getInt(3), cursor.getDouble(4),cursor.getInt(5));
                Servicos.add(aux);
            }while(cursor.moveToNext());
            cursor.close();
        }
        return Servicos;
    }

    //endregion

    //region CRUD Users

    public User adicionarUserBD(User u){
        ContentValues values = new ContentValues();
        values.put(ID,u.getId());
        values.put(USERNAME,u.getUsername());
        values.put(AUTH_KEY,u.getAuth_key());
        values.put(PASSWORD_HASH,u.getPassword_hash());
        values.put(PASSWORD_RESET_TOKEN,u.getPassword_reset_token());
        values.put(EMAIL,u.getEmail());
        values.put(STATUS,u.getStatus());
        values.put(CREATED_AT,u.getCreated_at());
        values.put(UPDATED_AT,u.getUpdated_at());
        values.put(VERIFICATION_TOKEN,u.getVerification_token());

        long id = this.db.insert(USERS, null,values);

        if(id > -1) {
            u.setId((int) id);
            return u;
        }

        return null;
    }
    public boolean editarUserBD(User u){
        ContentValues values = new ContentValues();
        values.put(USERNAME,u.getUsername());
        values.put(EMAIL,u.getEmail());
        int nLinhas = this.db.update(USERS, values ,ID + "=?", new String[]{u.getId() + ""});
        return nLinhas == 1;
    }

    public boolean removerUserBD(int id){
        int nLinhas = this.db.delete(USERS, ID + "=?", new String[]{id + ""});
        return nLinhas == 1;
    }

    public User getUserByIdBD(int userId) {
        User user = null;
        Cursor cursor = null;
        try {
            cursor = this.db.query(
                    USERS,
                    new String[]{ID, USERNAME, AUTH_KEY, PASSWORD_HASH, PASSWORD_RESET_TOKEN, EMAIL, STATUS, CREATED_AT, UPDATED_AT, VERIFICATION_TOKEN},
                    ID + "=?",
                    new String[]{String.valueOf(userId)},
                    null, null, null
            );

            if (cursor != null && cursor.moveToFirst()) {
                user = new User(
                        cursor.getInt(0),
                        cursor.getString(1),
                        cursor.getString(2),
                        cursor.getString(3),
                        cursor.getString(4),
                        cursor.getString(5),
                        cursor.getInt(6),
                        cursor.getInt(7),
                        cursor.getInt(8),
                        cursor.getString(9)
                );
            }
        } finally {
            if (cursor != null) {
                cursor.close();
            }
        }
        return user;
    }

    //endregion

    //region Userprofiles

    public Userprofile adicionarUserProfileBD(Userprofile up){
        ContentValues values = new ContentValues();
        values.put(ID,up.getId());
        values.put(NOME,up.getNome());
        values.put(MORADA,up.getMorada());
        values.put(TELEFONE,up.getTelefone());
        values.put(NIF,up.getNif());
        values.put(USER_ID,up.getUser_id());

        long id = this.db.insert(USERPROFILES, null,values);

        if(id > -1) {
            up.setId((int) id);
            return up;
        }

        return null;
    }
    public boolean editarUserProfileBD(Userprofile up){
        ContentValues values = new ContentValues();
        values.put(NOME,up.getNome());
        values.put(MORADA,up.getMorada());
        values.put(NIF,up.getNif());
        values.put(TELEFONE,up.getTelefone());

        int nLinhas = this.db.update(USERPROFILES, values ,ID + "=?", new String[]{up.getId() + ""});

        return nLinhas == 1;
    }

    public boolean removerUserProfileBD(int id){
        int nLinhas = this.db.delete(USERPROFILES, USER_ID + "=?", new String[]{id + ""});
        return nLinhas == 1;
    }

    //endregion
}
