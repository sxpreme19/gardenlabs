package com.example.amsi_project.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.ArrayList;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.amsi_project.R;
import com.example.amsi_project.modelo.Book;

public class ListaLivrosAdaptador extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Book> Books;

    public ListaLivrosAdaptador(ArrayList<Book> books, Context context) {
        Books = books;
        this.context = context;
    }

    @Override
    public int getCount() {
        return Books.size();
    }

    @Override
    public Object getItem(int i) {
        return Books.get(i);
    }

    @Override
    public long getItemId(int i) {
        return Books.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if(inflater == null)
        {
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }
        if(view == null)
        {
            view = inflater.inflate(R.layout.item_lista_livro, null);
        }

        //otimização
        ViewHolderLista viewHolder = (ViewHolderLista) view.getTag();
        if(viewHolder == null)
        {
            viewHolder = new ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(Books.get(i));


        return view;
    }

    private class ViewHolderLista{
        private TextView tvTitulo, tvSerie, tvAno, tvAutor;
        private ImageView imgCapa;

        public ViewHolderLista(View view){
           tvTitulo = view.findViewById(R.id.tvTitulo);
           tvSerie = view.findViewById(R.id.tvDuracao);
           tvAno = view.findViewById(R.id.tvPreco);
           tvAutor = view.findViewById(R.id.tvTitulo);
           imgCapa = view.findViewById(R.id.imgCapa);
        }

        public void update(Book b){
            tvTitulo.setText(b.getTitulo());
            tvSerie.setText(b.getSerie());
            tvAno.setText(b.getAno() + "");
            tvAutor.setText(b.getAutor());
            //imgCapa.setImageResource(b.getCapa());
            Glide.with(context)
                    .load(b.getCapa())
                    .placeholder(R.drawable.logoipl)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgCapa);
        }
    }
}
