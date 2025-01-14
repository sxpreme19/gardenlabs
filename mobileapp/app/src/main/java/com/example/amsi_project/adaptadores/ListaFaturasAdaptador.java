package com.example.amsi_project.adaptadores;

import static androidx.core.content.ContextCompat.startActivity;

import static java.security.AccessController.getContext;

import android.content.Context;
import android.content.Intent;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.fragment.app.FragmentActivity;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.amsi_project.CartFragment;
import com.example.amsi_project.DetalhesServicoActivity;
import com.example.amsi_project.R;
import com.example.amsi_project.modelo.BDHelper;
import com.example.amsi_project.modelo.Fatura;
import com.example.amsi_project.modelo.Linhafatura;
import com.example.amsi_project.modelo.Servico;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Locale;

public class ListaFaturasAdaptador extends BaseAdapter {
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Fatura> invoices;

    public ListaFaturasAdaptador(ArrayList<Fatura> faturas, Context context) {
        invoices = faturas;
        this.context = context;
    }

    @Override
    public int getCount() {
        return invoices.size();
    }

    @Override
    public Object getItem(int i) {
        return invoices.get(i);
    }

    @Override
    public long getItemId(int i) {
        return invoices.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if(inflater == null)
        {
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }
        if(view == null)
        {
            view = inflater.inflate(R.layout.item_lista_faturas, null);
        }

        //otimização
        ListaFaturasAdaptador.ViewHolderLista viewHolder = (ListaFaturasAdaptador.ViewHolderLista) view.getTag();
        if(viewHolder == null)
        {
            viewHolder = new ListaFaturasAdaptador.ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(invoices.get(i));


        return view;
    }

    private class ViewHolderLista{
        private TextView tvInvoiceId, tvData, tvTotal;
        private ImageView imgCapa;

        public ViewHolderLista(View view){
            tvInvoiceId = view.findViewById(R.id.tvInvoiceId);
            tvData = view.findViewById(R.id.tvData);
            tvTotal = view.findViewById(R.id.tvTotal);
            imgCapa = view.findViewById(R.id.imgCapa);
        }

        public void update(Fatura f){
            tvInvoiceId.setText(String.valueOf(f.getId()));
            SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss", Locale.getDefault());
            String formattedDate = sdf.format(f.getDatahora());
            tvData.setText(formattedDate);
            tvTotal.setText(f.getTotal()+"€");
            Glide.with(context)
                    .load(R.drawable.ic_action_invoice)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgCapa);
        }
    }
}
