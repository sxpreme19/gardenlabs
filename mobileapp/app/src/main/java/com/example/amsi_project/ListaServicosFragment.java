package com.example.amsi_project;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.SearchView;
import android.widget.Toast;

import com.example.amsi_project.adaptadores.ListaServicosAdaptador;
import com.example.amsi_project.listeners.ServicosListener;
import com.example.amsi_project.modelo.Servico;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import java.util.ArrayList;


public class ListaServicosFragment extends Fragment implements ServicosListener {

    private ListView lvServicos;
    private FloatingActionButton fabFilters;
    private ArrayList<Servico> servicos;

    public ListaServicosFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_lista_servicos, container, false);
        setHasOptionsMenu(true);


        lvServicos = view.findViewById(R.id.lvServicos);
        lvServicos.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                Intent intent = new Intent(getContext(), DetalhesServicoActivity.class);
                intent.putExtra("ID",(int) l);
                startActivity(intent);
            }
        });
        fabFilters = view.findViewById(R.id.fabFilters);
        fabFilters.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showFilterDialog();
            }
        });
        SingletonGardenLabsManager.getInstance(getContext()).setServicosListener(this);
        SingletonGardenLabsManager.getInstance(getContext()).getAllServicesAPI(getContext());

        return view;
    }

    @Override
    public void onCreateOptionsMenu(@NonNull Menu menu, @NonNull MenuInflater inflater) {
        inflater.inflate(R.menu.menu_pesquisa,menu);
        super.onCreateOptionsMenu(menu, inflater);
        MenuItem itemPesquisa = menu.findItem(R.id.itemPesquisa);

        SearchView searchView = (SearchView) itemPesquisa.getActionView();
        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String s) {
                return false;
            }

            @Override
            public boolean onQueryTextChange(String s) {
                ArrayList<Servico> tempServicos = new ArrayList<>();
                for (Servico l: SingletonGardenLabsManager.getInstance(getContext()).getServicosBD()){
                    if (l.getTitulo().toLowerCase().contains(s.toLowerCase()))
                        tempServicos.add(l);
                }
                lvServicos.setAdapter(new ListaServicosAdaptador(tempServicos,getContext()));
                return true;
            }
        });
    }

    @Override
    public void onRefreshListaServicos(ArrayList<Servico> listaServicos) {
        if(listaServicos != null){
            lvServicos.setAdapter(new ListaServicosAdaptador(listaServicos,getContext()));
        }
    }

    private void showFilterDialog() {
        LayoutInflater inflater = LayoutInflater.from(getContext());
        View dialogView = inflater.inflate(R.layout.dialog_filters_servicos, null);

        AlertDialog.Builder builder = new AlertDialog.Builder(getContext());
        builder.setTitle("Filter Services");
        builder.setView(dialogView);

        // Get references to the EditTexts in the dialog
        EditText etMinPrice = dialogView.findViewById(R.id.etMinPrice);
        EditText etMaxPrice = dialogView.findViewById(R.id.etMaxPrice);
        EditText etMinDuration = dialogView.findViewById(R.id.etMinDuration);
        EditText etMaxDuration = dialogView.findViewById(R.id.etMaxDuration);

        // Set up buttons
        builder.setPositiveButton("Apply", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                String minPriceStr = etMinPrice.getText().toString();
                String maxPriceStr = etMaxPrice.getText().toString();
                String minDurationStr = etMinDuration.getText().toString();
                String maxDurationStr = etMaxDuration.getText().toString();

                double minPrice = minPriceStr.isEmpty() ? 0 : Double.parseDouble(minPriceStr);
                double maxPrice = maxPriceStr.isEmpty() ? Double.MAX_VALUE : Double.parseDouble(maxPriceStr);
                int minDuration = minDurationStr.isEmpty() ? 0 : Integer.parseInt(minDurationStr);
                int maxDuration = maxDurationStr.isEmpty() ? Integer.MAX_VALUE : Integer.parseInt(maxDurationStr);

                if (minPrice > maxPrice) {
                    Toast.makeText(getContext(), "Min Price cannot be greater than Max Price.", Toast.LENGTH_SHORT).show();
                    SingletonGardenLabsManager.getInstance(getContext()).getAllServicesAPI(getContext());
                    return;
                }

                if (minDuration > maxDuration) {
                    Toast.makeText(getContext(), "Min Price cannot be greater than Max Price.", Toast.LENGTH_SHORT).show();
                    SingletonGardenLabsManager.getInstance(getContext()).getAllServicesAPI(getContext());
                    return;
                }

                SingletonGardenLabsManager.getInstance(getContext()).getAllServiceswFiltersAPI(minPrice,maxPrice,minDuration,maxDuration,getContext());
            }
        });
        builder.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
            }
        });

        // Show the dialog
        builder.create().show();
    }


}