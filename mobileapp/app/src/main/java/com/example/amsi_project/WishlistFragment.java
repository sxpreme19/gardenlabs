package com.example.amsi_project;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.Toast;

import com.example.amsi_project.adaptadores.ListaFavoritosAdaptador;
import com.example.amsi_project.adaptadores.ListaServicosAdaptador;
import com.example.amsi_project.listeners.FavoritosListener;
import com.example.amsi_project.modelo.Favorito;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

import java.util.ArrayList;

public class WishlistFragment extends Fragment implements FavoritosListener {

    public static final int ADD = 100,EDIT = 200, DELETE = 300;
    private ListView lvFavoritos;
    private ArrayList<Favorito> favoritos;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_wishlist, container, false);

        lvFavoritos = view.findViewById(R.id.lvFavoritos);
        SingletonGardenLabsManager.getInstance(getContext()).setFavoritosListener(this);
        SingletonGardenLabsManager.getInstance(getContext()).getFavoritosAPI(getContext());

        return view;
    }

    @Override
    public void onRefreshListaFavoritos(ArrayList<Favorito> favoritos) {
        if(lvFavoritos != null){
            lvFavoritos.setAdapter(new ListaFavoritosAdaptador(favoritos,getContext()));
        }
    }
}