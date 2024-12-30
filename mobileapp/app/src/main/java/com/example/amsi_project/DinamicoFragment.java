package com.example.amsi_project;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.amsi_project.modelo.Book;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

import java.util.ArrayList;

public class DinamicoFragment extends Fragment {

    private TextView tvTitulo, tvSerie, tvAutor, tvAno;
    private ImageView imgCapa;

    public DinamicoFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_dinamico, container, false);

        imgCapa=view.findViewById(R.id.imgCapa);
        tvTitulo=view.findViewById(R.id.tvTitulo);
        tvSerie=view.findViewById(R.id.tvSerie);
        tvAutor=view.findViewById(R.id.tvAutor);
        tvAno=view.findViewById(R.id.tvAno);

        carregarLivro();
        return view;
    }

    private void carregarLivro() {
        ArrayList<Book> books = SingletonGardenLabsManager.getInstance(getContext()).getBooksBD();
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

