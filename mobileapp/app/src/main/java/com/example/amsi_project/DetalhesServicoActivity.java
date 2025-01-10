package com.example.amsi_project;

import android.content.DialogInterface;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.amsi_project.listeners.ServicoListener;
import com.example.amsi_project.modelo.Servico;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

public class DetalhesServicoActivity extends AppCompatActivity implements ServicoListener {

    public static final String DEFAULT_IMG = "http://amsi.dei.estg.ipleiria.pt/img/ipl_semfundo.png";
    private EditText etTitulo, etDescricao, etDuracao, etPreco,etPrestadorID;
    private Button btnAddtoCart;
    private ImageButton btnAddtoWishlist;
    private ImageView imgCapa;
    //private FloatingActionButton fabDetalhes;
    private Servico servico;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhes_servico);

        int id=getIntent().getIntExtra("ID", 0);
        servico = SingletonGardenLabsManager.getInstance(getApplicationContext()).getServico(id);
        etTitulo=findViewById(R.id.etTitulo);
        etDescricao=findViewById(R.id.etDescricao);
        etDuracao=findViewById(R.id.etDuracao);
        etPreco=findViewById(R.id.etPreco);
        etPrestadorID=findViewById(R.id.etPrestadorID);
        imgCapa=findViewById(R.id.imgCapa);
        btnAddtoCart=findViewById(R.id.btnAddToCart);
        btnAddtoWishlist=findViewById(R.id.btnWishlist);

        //fabDetalhes=findViewById(R.id.fabDetalhes);
        if (servico != null)
            carregarServicos();
        else setTitle("Novo livro");

        SingletonGardenLabsManager.getInstance(getApplicationContext()).setServicoListener(this);

        btnAddtoCart.setOnClickListener( new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SingletonGardenLabsManager.getInstance(getApplicationContext()).adicionarCartLineAPI(servico,getApplicationContext());
            }
        });

        /*fabDetalhes.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                    if(servico!=null) {
                        servico.setTitulo(etTitulo.getText().toString());
                        servico.setDescricao(etDescricao.getText().toString());
                        servico.setDuracao(Integer.parseInt(etDuracao.getText().toString()));
                        servico.setPreco(Double.parseDouble(etPreco.getText().toString()));
                        servico.setPrestador_id(Integer.parseInt(etPrestadorID.getText().toString()));
                        SingletonGardenLabsManager.getInstance(getApplicationContext()).editarServicoAPI(servico, getApplicationContext());
                    }
                    else {
                        servico = new Servico(0, etTitulo.getText().toString(), etDescricao.getText().toString(),  Integer.parseInt(etDuracao.getText().toString()),Double.parseDouble(etPreco.getText().toString()),Integer.parseInt(etPrestadorID.getText().toString()));
                        SingletonGardenLabsManager.getInstance(getApplicationContext()).adicionarServicoAPI(servico, getApplicationContext());
                    }
            }
        });*/
    }

    private void carregarServicos() {
        if (servico != null) {
            String titulo = servico.getTitulo();
            etTitulo.setText(titulo);
            etDescricao.setText(servico.getDescricao());
            etDuracao.setText(String.valueOf(servico.getDuracao()));
            etPreco.setText(String.valueOf(servico.getPreco()));
            etPrestadorID.setText(String.valueOf(servico.getPrestador_id()));
            Glide.with(getApplicationContext())
                    .load(R.drawable.ic_action_service)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgCapa);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        if(servico!=null) {
            getMenuInflater().inflate(R.menu.menu_remover,menu);
            return super.onCreateOptionsMenu(menu);
        }
        return false;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        if(item.getItemId()==R.id.itemGoBack) {
            finish();
            return super.onOptionsItemSelected(item);
        }
        return false;
    }

    private void dialogConfirmRemover() {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle("Remover Livro")
                .setMessage("Tem a certeza que pretende remover o Livro?")
                .setPositiveButton("SIMMMM :DD", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        SingletonGardenLabsManager.getInstance(getApplicationContext()).removerServicoAPI(servico, getApplicationContext());
                    }
                })
                .setNegativeButton("não :/", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        //Nada :D
                    }
                })
                .setIcon(android.R.drawable.ic_delete)
                .show();
    }

    @Override
    public void onRefreshDetalhes(int op) {
        setResult(RESULT_OK);
        finish();
    }
}