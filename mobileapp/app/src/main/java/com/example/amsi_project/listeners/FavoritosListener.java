package com.example.amsi_project.listeners;

import com.example.amsi_project.modelo.Favorito;

import java.util.ArrayList;

public interface FavoritosListener {
    void onRefreshListaFavoritos(ArrayList<Favorito> favoritos);
}
