package com.example.amsi_project;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.TextView;

import com.example.amsi_project.adaptadores.ListaLinhasCarrinhoAdaptador;
import com.example.amsi_project.listeners.CartLinesListener;
import com.example.amsi_project.listeners.CartListener;
import com.example.amsi_project.modelo.Linhacarrinhoservico;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

import java.util.ArrayList;

public class CartFragment extends Fragment implements CartListener, CartLinesListener {

    private ListView lvCartLines;
    private TextView tvTotal;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_cart, container, false);

        lvCartLines = view.findViewById(R.id.lvLinhasCarrinho);
        tvTotal = view.findViewById(R.id.tvTotalCarrinho);

        SingletonGardenLabsManager.getInstance(getContext()).setCartListener(this);
        SingletonGardenLabsManager.getInstance(getContext()).setCartLinesListener(this);
        SingletonGardenLabsManager.getInstance(getContext()).getCartAPI(getContext());
        SingletonGardenLabsManager.getInstance(getContext()).getCartLinesAPI(getContext());

        return view;
    }

    @Override
    public void onRefreshDetalhes(Double total) {
        tvTotal.setText("Total: " + total + "€");
    }

    @Override
    public void onRefreshListaLinhasCarrinho(ArrayList<Linhacarrinhoservico> listLinhasCarrinho) {
        if(listLinhasCarrinho != null){
            Log.d("LINHAS", String.valueOf(listLinhasCarrinho));
            lvCartLines.setAdapter(new ListaLinhasCarrinhoAdaptador(listLinhasCarrinho,getContext()));
        }
    }
}