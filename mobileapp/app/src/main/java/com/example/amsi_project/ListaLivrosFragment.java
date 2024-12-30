package com.example.amsi_project;

import android.app.Activity;
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
import android.widget.ListView;
import android.widget.SearchView;
import android.widget.Toast;

import com.example.amsi_project.adaptadores.ListaLivrosAdaptador;
import com.example.amsi_project.listeners.LivrosListener;
import com.example.amsi_project.modelo.Book;
import com.example.amsi_project.modelo.SingletonBookManager;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import java.util.ArrayList;


public class ListaLivrosFragment extends Fragment implements LivrosListener {

    public static final int ADD = 100,EDIT = 200, DELETE = 300;
    private ListView lvLivros;
    private FloatingActionButton fabLista;
    private ArrayList<Book> books;

    public ListaLivrosFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_lista_livros, container, false);
        setHasOptionsMenu(true);


        lvLivros = view.findViewById(R.id.lvLivros);
        //books = SingletonBookManager.getInstance(getContext()).getBooksBD();
        //lvLivros.setAdapter(new ListaLivrosAdaptador(books,getContext()));

        lvLivros.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                //Toast.makeText(getContext(),books.get(i).getTitulo(),Toast.LENGTH_LONG).show();
                Intent intent = new Intent(getContext(), DetalhesLivroActivity.class);
                intent.putExtra("ID",(int) l);
                //startActivity(intent);
                startActivityForResult(intent, EDIT);
            }
        });
        fabLista = view.findViewById(R.id.fabLista);
        fabLista.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getContext(),DetalhesLivroActivity.class);
                //startActivity(intent);
                startActivityForResult(intent, ADD);
            }
        });
        SingletonBookManager.getInstance(getContext()).setLivrosListener(this);
        SingletonBookManager.getInstance(getContext()).getAllLivrosAPI(getContext());

        return view;
    }

    //requestCode: código enviado no startActivityForResult
    //resultCode:  código devolvido pela atividade invocada no startActivityForResult -> DetalhesActivity
    @Override
    public void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if(resultCode==Activity.RESULT_OK) {
           // books = SingletonBookManager.getInstance(getContext()).getBooksBD();
            // lvLivros.setAdapter(new ListaLivrosAdaptador(books, getContext()));
            SingletonBookManager.getInstance(getContext()).getAllLivrosAPI(getContext());
            switch (requestCode) {
                case ADD:
                    Toast.makeText(getContext(), "Livro adicionado com sucesso", Toast.LENGTH_LONG).show();
                    break;
                case EDIT:
                    Toast.makeText(getContext(), "Livro editado com sucesso", Toast.LENGTH_LONG).show();
                    break;
                default:
                    Toast.makeText(getContext(), "Livro removido com sucesso", Toast.LENGTH_LONG).show();
            }
        }
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
                ArrayList<Book> tempLivros = new ArrayList<>();
                for (Book l: SingletonBookManager.getInstance(getContext()).getBooksBD()){
                    if (l.getTitulo().toLowerCase().contains(s.toLowerCase()))
                        tempLivros.add(l);
                }
                lvLivros.setAdapter(new ListaLivrosAdaptador(tempLivros,getContext()));
                return true;
            }
        });
    }

    @Override
    public void onRefreshListaLivros(ArrayList<Book> listaLivros) {
        if(listaLivros != null){
            lvLivros.setAdapter(new ListaLivrosAdaptador(listaLivros,getContext()));
        }
    }
}