package com.example.amsi_project;

import android.content.Context;
import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.amsi_project.adaptadores.ListaLinhasCarrinhoAdaptador;
import com.example.amsi_project.adaptadores.ListaReviewsAdaptador;
import com.example.amsi_project.listeners.ReviewsListener;
import com.example.amsi_project.listeners.UserProfileListener;
import com.example.amsi_project.modelo.BDHelper;
import com.example.amsi_project.modelo.Review;
import com.example.amsi_project.modelo.Servico;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

import java.util.ArrayList;

public class DetalhesServicoActivity extends AppCompatActivity implements UserProfileListener, ReviewsListener {

    private ListView lvReviews;
    private TextView tvTitulo, tvDescricao, tvDuracao, tvPreco,tvPrestadorID,tvNoReviews;
    private ImageButton btnAddtoCart,btnAddtoWishlist;
    private ImageView imgCapa;
    private Servico servico;
    private BDHelper bdHelper;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhes_servico);
        setTitle("Service Details");

        bdHelper = new BDHelper(getApplicationContext());

        int id=getIntent().getIntExtra("ID", 0);
        servico = SingletonGardenLabsManager.getInstance(getApplicationContext()).getServico(id);
        tvTitulo=findViewById(R.id.tvTitulo);
        tvDescricao=findViewById(R.id.tvDescricao);
        tvDuracao=findViewById(R.id.tvDuracao);
        tvPreco=findViewById(R.id.tvPreco);
        tvPrestadorID=findViewById(R.id.tvPrestadorID);
        imgCapa=findViewById(R.id.imgCapa);
        btnAddtoCart=findViewById(R.id.btnAddToCart);
        btnAddtoWishlist=findViewById(R.id.btnWishlist);
        lvReviews = findViewById(R.id.lvReviews);
        tvNoReviews = findViewById(R.id.tvNoReviews);

        SingletonGardenLabsManager.getInstance(getApplicationContext()).setUserProfileListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).setReviewsListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).getProviderAPI(servico.getPrestador_id(),getApplicationContext());
        SingletonGardenLabsManager.getInstance(getApplicationContext()).getServiceReviewsAPI(servico.getId(),getApplicationContext());

        if (servico != null)
            carregarServicos();

        btnAddtoCart.setOnClickListener( new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SingletonGardenLabsManager.getInstance(getApplicationContext()).adicionarCartLineAPI(servico,getApplicationContext());
            }
        });

        btnAddtoWishlist.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if (bdHelper.isFavoritoServicoExists(getUserProfileIDFromSharedPreferences(getApplicationContext()),servico.getId())) {
                    SingletonGardenLabsManager.getInstance(getApplicationContext()).removerFavoritoAPI(bdHelper.getFavoritoBD(getUserProfileIDFromSharedPreferences(getApplicationContext()),servico.getId()), getApplicationContext());
                    btnAddtoWishlist.setImageResource(R.drawable.ic_action_not_wishlist);
                    Toast.makeText(getApplicationContext(), "Removed from Wishlist", Toast.LENGTH_SHORT).show();
                } else {
                    SingletonGardenLabsManager.getInstance(getApplicationContext()).adicionarFavoritoAPI(servico, getApplicationContext());
                    btnAddtoWishlist.setImageResource(R.drawable.ic_action_wishlist);
                    Toast.makeText(getApplicationContext(), "Added to Wishlist", Toast.LENGTH_SHORT).show();
                }
            }
        });

    }

    private void carregarServicos() {
        if (servico != null) {

            String titulo = servico.getTitulo();
            tvTitulo.setText(titulo);
            tvDescricao.setText(servico.getDescricao());
            tvDuracao.setText(servico.getDuracao() + " dias");
            tvPreco.setText(servico.getPreco() + "€");
            Glide.with(getApplicationContext())
                    .load(R.drawable.serviceimg)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgCapa);
        }

        if(bdHelper.isFavoritoServicoExists(getUserProfileIDFromSharedPreferences(getApplicationContext()),servico.getId())){
            btnAddtoWishlist.setImageResource(R.drawable.ic_action_wishlist);
        }else{
            btnAddtoWishlist.setImageResource(R.drawable.ic_action_not_wishlist);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        if(servico!=null) {
            getMenuInflater().inflate(R.menu.menu_review,menu);
            getMenuInflater().inflate(R.menu.menu_goback,menu);
            return super.onCreateOptionsMenu(menu);
        }
        return false;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        if(item.getItemId()==R.id.itemReview) {
            showReviewDialog();
        }
        else if(item.getItemId()==R.id.itemGoBack) {
            finish();
            return super.onOptionsItemSelected(item);
        }
        return false;
    }

    private void showReviewDialog() {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle("Leave a Review");

        LinearLayout layout = new LinearLayout(this);
        layout.setOrientation(LinearLayout.VERTICAL);
        layout.setPadding(50, 40, 50, 10);

        final EditText inputContent = new EditText(this);
        inputContent.setHint("Content");
        layout.addView(inputContent);

        final EditText inputRating = new EditText(this);
        inputRating.setHint("Rating (0-5)");
        inputRating.setInputType(android.text.InputType.TYPE_CLASS_NUMBER | android.text.InputType.TYPE_NUMBER_FLAG_DECIMAL);
        layout.addView(inputRating);

        builder.setView(layout);

        builder.setPositiveButton("Submit", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int id) {
                String conteudo = inputContent.getText().toString();
                double avaliacao = Double.parseDouble(inputRating.getText().toString());
                SingletonGardenLabsManager.getInstance(getApplicationContext()).adicionarReviewAPI(conteudo, avaliacao, servico.getId(),getApplicationContext());
            }
        });
        builder.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int id) {
                dialog.cancel();
            }
        });

        builder.create().show();
    }

    @Override
    public void onRefreshDetalhes(String nome, String morada, Integer telefone, Integer nif) {
        tvPrestadorID.setText(nome);
    }

    public int getUserProfileIDFromSharedPreferences(Context context) {
        SharedPreferences sharedPref = context.getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        int userprofileID = sharedPref.getInt("profileid", -1); // Retrieve the user ID as Integer
        return userprofileID; // Return the token, or null if not found
    }

    @Override
    public void onRefreshListaReviews(ArrayList<Review> listReviews) {
        if(listReviews != null && !listReviews.isEmpty()){
            lvReviews.setVisibility(View.VISIBLE);
            lvReviews.setAdapter(new ListaReviewsAdaptador(listReviews,getApplicationContext()));
            tvNoReviews.setVisibility(View.GONE);
        }else{
            tvNoReviews.setVisibility(View.VISIBLE);
            lvReviews.setVisibility(View.GONE);
        }
    }
}