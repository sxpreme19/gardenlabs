package com.example.amsi_project.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.amsi_project.R;
import com.example.amsi_project.modelo.Servico;

import java.util.ArrayList;

public class ListaServicosAdaptador extends BaseAdapter {
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Servico> Services;

    public ListaServicosAdaptador(ArrayList<Servico> services, Context context) {
        Services = services;
        this.context = context;
    }

    @Override
    public int getCount() {
        return Services.size();
    }

    @Override
    public Object getItem(int i) {
        return Services.get(i);
    }

    @Override
    public long getItemId(int i) {
        return Services.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if(inflater == null)
        {
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }
        if(view == null)
        {
            view = inflater.inflate(R.layout.item_lista_servico, null);
        }

        //otimização
        ListaServicosAdaptador.ViewHolderLista viewHolder = (ListaServicosAdaptador.ViewHolderLista) view.getTag();
        if(viewHolder == null)
        {
            viewHolder = new ListaServicosAdaptador.ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(Services.get(i));


        return view;
    }

    private class ViewHolderLista{
        private TextView tvTitulo, tvPreco, tvDuracao;
        private ImageView imgCapa;

        public ViewHolderLista(View view){
            tvTitulo = view.findViewById(R.id.tvTitulo);
            tvDuracao = view.findViewById(R.id.tvDuracao);
            tvPreco = view.findViewById(R.id.tvPreco);
            imgCapa = view.findViewById(R.id.imgCapa);
        }

        public void update(Servico s){
            tvTitulo.setText(s.getTitulo());
            tvDuracao.setText(s.getDuracao() + " dias");
            tvPreco.setText(s.getPreco()+"€");
            Glide.with(context)
                    .load(R.drawable.serviceimg)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgCapa);
        }
    }
}
