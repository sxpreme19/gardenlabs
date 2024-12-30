package com.example.amsi_project;

import android.os.Bundle;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.amsi_project.modelo.Book;
import com.example.amsi_project.modelo.SingletonBookManager;

import java.util.ArrayList;

public class DetalhesDinamicoActivity extends AppCompatActivity {

    private TextView tvTitulo, tvSerie, tvAutor, tvAno;
    private ImageView imgCapa;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhes_dinamico);

        setTitle(getString(R.string.txt_dadinamico));

        imgCapa=findViewById(R.id.imgCapa);
        tvTitulo=findViewById(R.id.tvTitulo);
        tvSerie=findViewById(R.id.tvSerie);
        tvAutor=findViewById(R.id.tvAutor);
        tvAno=findViewById(R.id.tvAno);

        carregarLivro();
    }

    private void carregarLivro() {
        ArrayList<Book> books = SingletonBookManager.getInstance(getApplicationContext()).getBooksBD();
        if(books.size()>0) {
            Book book = books.get(0);
            tvTitulo.setText(book.getTitulo());
            tvSerie.setText(book.getSerie());
            tvAutor.setText(book.getAutor());
            tvAno.setText(book.getAno()+"");
            //imgCapa.setImageResource(book.getCapa());
        }
    }
}