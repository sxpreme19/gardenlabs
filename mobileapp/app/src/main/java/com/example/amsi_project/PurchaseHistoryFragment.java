package com.example.amsi_project;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;

import com.example.amsi_project.adaptadores.ListaFaturasAdaptador;
import com.example.amsi_project.listeners.FaturaListener;
import com.example.amsi_project.listeners.FaturasListener;
import com.example.amsi_project.modelo.Fatura;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

import java.util.ArrayList;
import java.util.Date;


public class PurchaseHistoryFragment extends Fragment implements FaturasListener {

    private ListView lvFaturas;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_purchase_history, container, false);

        lvFaturas = view.findViewById(R.id.lvFaturas);
        lvFaturas.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                Intent intent = new Intent(getContext(), DetalhesFaturaActivity.class);
                intent.putExtra("ID",(int) l);
                startActivity(intent);
            }
        });

        SingletonGardenLabsManager.getInstance(getContext()).setFaturasListener(this);
        SingletonGardenLabsManager.getInstance(getContext()).getFaturasAPI(getContext());

        return view;
    }

    @Override
    public void onRefreshListaFaturas(ArrayList<Fatura> faturas) {
        if(faturas != null){
            lvFaturas.setAdapter(new ListaFaturasAdaptador(faturas,getContext()));
        }
    }
}