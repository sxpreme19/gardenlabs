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
import com.example.amsi_project.WishlistFragment;
import com.example.amsi_project.modelo.BDHelper;
import com.example.amsi_project.modelo.Favorito;
import com.example.amsi_project.modelo.Linhacarrinhoservico;
import com.example.amsi_project.modelo.Servico;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

import java.util.ArrayList;

public class ListaFavoritosAdaptador extends BaseAdapter {
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Favorito> favoritos;

    public ListaFavoritosAdaptador(ArrayList<Favorito> favorites, Context context) {
        favoritos = favorites;
        this.context = context;
    }

    @Override
    public int getCount() {
        return favoritos.size();
    }

    @Override
    public Object getItem(int i) {
        return favoritos.get(i);
    }

    @Override
    public long getItemId(int i) {
        return favoritos.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if(inflater == null)
        {
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }
        if(view == null)
        {
            view = inflater.inflate(R.layout.item_lista_favoritos, null);
        }

        //otimização
        ListaFavoritosAdaptador.ViewHolderLista viewHolder = (ListaFavoritosAdaptador.ViewHolderLista) view.getTag();
        if(viewHolder == null)
        {
            viewHolder = new ListaFavoritosAdaptador.ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(favoritos.get(i));


        return view;
    }

    private class ViewHolderLista{
        private TextView tvTitulo, tvPreco, tvDuracao;
        private ImageView imgCapa;
        private ImageButton removeFromWishlist,addToCart;

        public ViewHolderLista(View view){
            tvTitulo = view.findViewById(R.id.tvTitulo);
            tvDuracao = view.findViewById(R.id.tvDuracao);
            tvPreco = view.findViewById(R.id.tvPreco);
            imgCapa = view.findViewById(R.id.imgCapa);
            removeFromWishlist = view.findViewById(R.id.btnRemove);
            addToCart = view.findViewById(R.id.btnAddtoCart);
        }

        public void update(Favorito f){

            Servico servico = getServicoById(f.getServico_id());

            tvTitulo.setText(servico.getTitulo());
            tvDuracao.setText(servico.getDuracao() + " dias");
            tvPreco.setText(servico.getPreco()+"€");
            Glide.with(context)
                    .load(R.drawable.serviceimg)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgCapa);

            removeFromWishlist.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    SingletonGardenLabsManager.getInstance(context).removerFavoritoAPI(f,context);

                    WishlistFragment wishlistFragment = new WishlistFragment();
                    ((FragmentActivity) context).getSupportFragmentManager().beginTransaction()
                            .replace(R.id.contentFragment, wishlistFragment)
                            .commit();
                    Toast.makeText(context, "Removido!", Toast.LENGTH_LONG).show();
                }
            });

            addToCart.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    SingletonGardenLabsManager.getInstance(context).adicionarCartLineAPI(getServicoById(f.getServico_id()),context);
                }
            });
        }
    }

    public Servico getServicoById(int servicoId) {
        BDHelper bdHelper = new BDHelper(context);
        return bdHelper.getServiceBD(servicoId);
    }

}
