package com.example.amsi_project.adaptadores;

import android.content.Context;
import android.content.SharedPreferences;
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
import com.example.amsi_project.R;
import com.example.amsi_project.modelo.BDHelper;
import com.example.amsi_project.modelo.Review;
import com.example.amsi_project.modelo.Servico;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;
import com.example.amsi_project.modelo.User;
import com.example.amsi_project.modelo.Userprofile;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Locale;

public class ListaReviewsAdaptador extends BaseAdapter {
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Review> reviews;

    public ListaReviewsAdaptador(ArrayList<Review> reviews, Context context) {
        this.reviews = reviews;
        this.context = context;
    }

    @Override
    public int getCount() {
        return reviews.size();
    }

    @Override
    public Object getItem(int i) {
        return reviews.get(i);
    }

    @Override
    public long getItemId(int i) {
        return reviews.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if(inflater == null)
        {
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }
        if(view == null)
        {
            view = inflater.inflate(R.layout.item_lista_reviews, null);
        }

        //otimização
        ListaReviewsAdaptador.ViewHolderLista viewHolder = (ListaReviewsAdaptador.ViewHolderLista) view.getTag();
        if(viewHolder == null)
        {
            viewHolder = new ListaReviewsAdaptador.ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(reviews.get(i));


        return view;
    }

    private class ViewHolderLista{
        private TextView tvConteudo, tvAvaliacao, tvPostedBy;
        private ImageView imgCapa;
        private ImageButton removeReview;

        public ViewHolderLista(View view){
            tvConteudo = view.findViewById(R.id.tvReviewContent);
            tvAvaliacao = view.findViewById(R.id.tvReviewEval);
            tvPostedBy = view.findViewById(R.id.tvReviewUser);
            imgCapa = view.findViewById(R.id.imgCapa);
            removeReview = view.findViewById(R.id.btnRemove);
        }

        public void update(Review r){

            if(r.getUserprofile_id() == getUserProfileIDFromSharedPreferences(context)){
                removeReview.setVisibility(View.VISIBLE);
                removeReview.setClickable(true);
                Log.d("CHANGIGN VISIBILITY", String.valueOf(removeReview.getVisibility()));
            }

            Userprofile userprofile = getUserProfileById(r.getUserprofile_id());
            User user = getUserById(userprofile.getUser_id());

            SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss", Locale.getDefault());
            String formattedDate = sdf.format(r.getDatahora());

            tvConteudo.setText(r.getConteudo());
            tvAvaliacao.setText(r.getAvaliacao()+"");
            tvPostedBy.setText(user.getUsername() + " on " + formattedDate);
            Glide.with(context)
                    .load(R.drawable.ic_action_user)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgCapa);

            removeReview.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    SingletonGardenLabsManager.getInstance(context).removerReviewAPI(r.getId(),context);
                    Toast.makeText(context, "Removido!", Toast.LENGTH_LONG).show();
                }
            });
        }
    }

    public Userprofile getUserProfileById(int profileID) {
        BDHelper bdHelper = new BDHelper(context);
        return bdHelper.getUserProfileBD(profileID);
    }

    public User getUserById(int id) {
        BDHelper bdHelper = new BDHelper(context);
        return bdHelper.getUserBD(id);
    }

    public int getUserProfileIDFromSharedPreferences(Context context) {
        SharedPreferences sharedPref = context.getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        int userprofileID = sharedPref.getInt("profileid", -1);
        return userprofileID;
    }

}
