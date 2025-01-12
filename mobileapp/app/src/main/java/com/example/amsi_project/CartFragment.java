package com.example.amsi_project;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.example.amsi_project.adaptadores.ListaLinhasCarrinhoAdaptador;
import com.example.amsi_project.listeners.CartLinesListener;
import com.example.amsi_project.listeners.CartListener;
import com.example.amsi_project.modelo.Linhacarrinhoservico;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

import java.util.ArrayList;

public class CartFragment extends Fragment implements CartListener, CartLinesListener {

    private ListView lvCartLines;
    private TextView tvTotal;
    private Button btnCheckout;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_cart, container, false);

        lvCartLines = view.findViewById(R.id.lvLinhasCarrinho);
        tvTotal = view.findViewById(R.id.tvTotalCarrinho);
        btnCheckout = view.findViewById(R.id.btnCheckout);

        btnCheckout.setOnClickListener( new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(lvCartLines.getAdapter() == null || lvCartLines.getAdapter().getCount() == 0){
                    Toast.makeText(getContext(), "Your cart is empty!", Toast.LENGTH_SHORT).show();
                }else{
                    Intent intent = new Intent(getContext(), CheckoutActivity.class);
                    startActivity(intent);
                }
            }
        });

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
            lvCartLines.setAdapter(new ListaLinhasCarrinhoAdaptador(listLinhasCarrinho,getContext()));
        }
    }
}