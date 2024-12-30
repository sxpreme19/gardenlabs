package com.example.amsi_project.modelo;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import androidx.annotation.Nullable;

import java.util.ArrayList;

public class LivroBDHelper extends SQLiteOpenHelper {

    //Nome da base de dados
    private static final String DB_NAME = "bdLivros";

    //Nome da tabela
    private static final String LIVROS = "Livros";

    //Nome das colunas da tabela livros
    private static final String  ID ="id", TITULO = "titulo", SERIE ="serie", AUTOR ="autor", ANO ="ano", CAPA ="capa";

    private final SQLiteDatabase db;


    public LivroBDHelper(@Nullable Context context) {
        super(context, DB_NAME, null, 1);
        this.db = getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        String sqlCriarTabela = "CREATE TABLE " + LIVROS + "(" +
                ID + " INTEGER PRIMARY KEY, "+
                TITULO + " TEXT NOT NULL, " +
                SERIE + " TEXT NOT NULL, " +
                AUTOR + " TEXT NOT NULL, " +
                ANO + " INTEGER NOT NULL, " +
                CAPA + " TEXT " +
                ");";
        sqLiteDatabase.execSQL(sqlCriarTabela);

    }

    @Override
    public void onUpgrade(SQLiteDatabase sqLiteDatabase, int i, int i1) {
        //Apagar tabelas e criar de novo
        String sqlDeleteTabela = "DROP TABLE IF EXISTS " + LIVROS;
        sqLiteDatabase.execSQL(sqlDeleteTabela);

        onCreate(sqLiteDatabase);
    }


    //METODOS CRUD DOS LIVROS
    public Book adicionarLivroBD(Book b){
        ContentValues values = new ContentValues();
        values.put(ID,b.getId());
        values.put(TITULO,b.getTitulo());
        values.put(SERIE,b.getSerie());
        values.put(AUTOR,b.getAutor());
        values.put(ANO,b.getAno());
        values.put(CAPA,b.getCapa());

        long id = this.db.insert(LIVROS, null,values);

        if(id > -1) {
            b.setId((int) id);
            return b;
        }

        return null;
    }

    public boolean editarLivroBD(Book b){
        ContentValues values = new ContentValues();
        values.put(TITULO,b.getTitulo());
        values.put(SERIE,b.getSerie());
        values.put(AUTOR,b.getAutor());
        values.put(ANO,b.getAno());
        values.put(CAPA,b.getCapa());

        int nLinhas = this.db.update(LIVROS, values ,ID + "=?", new String[]{b.getId() + ""});

        return nLinhas == 1;
    }

    public boolean removerLivroBD(int id){
        int nLinhas = this.db.delete(LIVROS, ID + "=?", new String[]{id + ""});
        return nLinhas == 1;
    }

    public void removerAllLivrosBD(){
        this.db.delete(LIVROS,null, null);
    }

    public ArrayList<Book> getAllLivrosBD(){

        ArrayList<Book> Livros = new ArrayList<>();

        Cursor cursor = this.db.query(LIVROS, new String[]{ID, TITULO, SERIE, AUTOR, ANO, CAPA},null, null,null, null, null);

        if(cursor.moveToFirst()){
            do{
                Book aux = new Book(cursor.getInt(0),cursor.getString(5),cursor.getInt(4), cursor.getString(1), cursor.getString(2),cursor.getString(3));
                Livros.add(aux);
            }while(cursor.moveToNext());
            cursor.close();
        }
        return Livros;
    }
}
