package com.example.amsi_project.adaptadores;

import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
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
import com.example.amsi_project.R;
import com.example.amsi_project.modelo.BDHelper;
import com.example.amsi_project.modelo.Linhacarrinhoservico;
import com.example.amsi_project.modelo.Servico;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

import java.util.ArrayList;

public class ListaLinhasCarrinhoAdaptador extends BaseAdapter {
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Linhacarrinhoservico> cartLines;

    public ListaLinhasCarrinhoAdaptador(ArrayList<Linhacarrinhoservico> cartlines, Context context) {
        cartLines = cartlines;
        this.context = context;
    }

    @Override
    public int getCount() {
        return cartLines.size();
    }

    @Override
    public Object getItem(int i) {
        return cartLines.get(i);
    }

    @Override
    public long getItemId(int i) {
        return cartLines.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if(inflater == null)
        {
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }
        if(view == null)
        {
            view = inflater.inflate(R.layout.item_lista_linhascarrinho, null);
        }

        //otimização
        ListaLinhasCarrinhoAdaptador.ViewHolderLista viewHolder = (ListaLinhasCarrinhoAdaptador.ViewHolderLista) view.getTag();
        if(viewHolder == null)
        {
            viewHolder = new ListaLinhasCarrinhoAdaptador.ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(cartLines.get(i));


        return view;
    }

    private class ViewHolderLista{
        private TextView tvTitulo, tvPreco, tvDuracao;
        private ImageView imgCapa;
        private ImageButton removeFromCart;

        public ViewHolderLista(View view){
            tvTitulo = view.findViewById(R.id.tvTitulo);
            tvDuracao = view.findViewById(R.id.tvDuracao);
            tvPreco = view.findViewById(R.id.tvPreco);
            imgCapa = view.findViewById(R.id.imgCapa);
            removeFromCart = view.findViewById(R.id.btnRemove);
        }

        public void update(Linhacarrinhoservico lcs){

            Servico servico = getServicoById(lcs.getServico_id());

            tvTitulo.setText(servico.getTitulo());
            tvDuracao.setText(servico.getDuracao() + " dias");
            tvPreco.setText(lcs.getPreco()+"€");
            Glide.with(context)
                    .load(R.drawable.ic_action_service)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgCapa);

            removeFromCart.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    SingletonGardenLabsManager.getInstance(context).removerCartLineAPI(lcs,context);

                    CartFragment cartFragment = new CartFragment();
                    ((FragmentActivity) context).getSupportFragmentManager().beginTransaction()
                            .replace(R.id.contentFragment, cartFragment)
                            .commit();
                    Toast.makeText(context, "Removido!", Toast.LENGTH_LONG).show();
                }
            });
        }
    }

    public Servico getServicoById(int servicoId) {
        BDHelper bdHelper = new BDHelper(context);
        return bdHelper.getServiceBD(servicoId);
    }

}
