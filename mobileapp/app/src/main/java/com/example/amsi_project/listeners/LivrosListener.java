package com.example.amsi_project.listeners;

import com.example.amsi_project.modelo.Book;

import java.util.ArrayList;

public interface LivrosListener {

    void onRefreshListaLivros(ArrayList<Book> listaLivros);
}
