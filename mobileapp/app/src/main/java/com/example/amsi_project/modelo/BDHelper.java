package com.example.amsi_project.modelo;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import androidx.annotation.Nullable;

import java.util.ArrayList;

public class BDHelper extends SQLiteOpenHelper {

    //Nome da base de dados
    private static final String DB_NAME = "bdGardenLabs";

    //Nome da tabela
    private static final String SERVICOS = "Servicos";

    //Nome das colunas da tabela livros
    private static final String  ID ="id", TITULO = "titulo", DESCRICAO ="descricao", DURACAO ="duracao", PRECO ="PRECO", PRESTADOR_ID ="prestador_id";

    private final SQLiteDatabase db;


    public BDHelper(@Nullable Context context) {
        super(context, DB_NAME, null, 1);
        this.db = getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        String sqlCriarTabela = "CREATE TABLE " + SERVICOS + "(" +
                ID + " INTEGER PRIMARY KEY, "+
                TITULO + " TEXT NOT NULL, " +
                DESCRICAO + " TEXT NOT NULL, " +
                DURACAO + " INTEGER NOT NULL, " +
                PRECO + " DOUBLE NOT NULL, " +
                PRESTADOR_ID + " INTEGER NOT NULL " +
                ");";
        sqLiteDatabase.execSQL(sqlCriarTabela);

    }

    @Override
    public void onUpgrade(SQLiteDatabase sqLiteDatabase, int i, int i1) {
        //Apagar tabelas e criar de novo
        String sqlDeleteTabela = "DROP TABLE IF EXISTS " + SERVICOS;
        sqLiteDatabase.execSQL(sqlDeleteTabela);

        onCreate(sqLiteDatabase);
    }


    //METODOS CRUD DOS LIVROS
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
}
