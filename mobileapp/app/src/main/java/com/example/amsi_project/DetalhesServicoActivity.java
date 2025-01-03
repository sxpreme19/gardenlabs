package com.example.amsi_project;

import android.content.DialogInterface;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
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
    private ImageView imgCapa;
    private FloatingActionButton fabDetalhes;
    private Servico servico;
    public static final int MIN_CHAR=3, MIN_NUMBER=4;

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
        fabDetalhes=findViewById(R.id.fabDetalhes);
        if (servico != null)
            carregarServicos();
        else setTitle("Novo livro");

        SingletonGardenLabsManager.getInstance(getApplicationContext()).setServicoListener(this);

        fabDetalhes.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                    if(servico!=null) {
                        servico.setTitulo(etTitulo.getText().toString());
                        servico.setDescricao(etDescricao.getText().toString());
                        servico.setDuracao(Integer.parseInt(etDuracao.getText().toString()));
                        servico.setPreco(Double.parseDouble(etPreco.getText().toString()));
                        servico.setPrestador_id(Integer.parseInt(etPrestadorID.getText().toString()));
                        /*SingletonBookManager.getInstance(getApplicationContext()).editBookBD(book);
                        Intent intent = new Intent();
                        setResult(RESULT_OK, intent);
                        finish();*/
                        SingletonGardenLabsManager.getInstance(getApplicationContext()).editarServicoAPI(servico, getApplicationContext());
                    }
                    else {
                        servico = new Servico(0, etTitulo.getText().toString(), etDescricao.getText().toString(),  Integer.parseInt(etDuracao.getText().toString()),Double.parseDouble(etPreco.getText().toString()),Integer.parseInt(etPrestadorID.getText().toString()));
                        SingletonGardenLabsManager.getInstance(getApplicationContext()).adicionarServicoAPI(servico, getApplicationContext());
                    }
                //if(isLivroValid()) {}
            }
        });
    }

    /*private boolean isLivroValid() {
        String titulo=etTitulo.getText().toString();
        String serie=etSerie.getText().toString();
        String autor=etAutor.getText().toString();
        String ano=etAno.getText().toString();
        if (titulo.length()<MIN_CHAR) {
            etTitulo.setError("Título inválido");
            return false;
        }
        if (autor.length()<MIN_CHAR) {
            etAutor.setError("Autor inválido");
            return false;
        }
        if (ano.length()<MIN_NUMBER) {
            etAno.setError("Ano inválido");
            return false;
        }
        if (serie.length()<MIN_CHAR) {
            etSerie.setError("Série inválida");
            return false;
        }
        return true;
    }*/

    private void carregarServicos() {
        if (servico != null) {
            String titulo = servico.getTitulo();
            etTitulo.setText(titulo);
            etDescricao.setText(servico.getDescricao());
            etDuracao.setText(String.valueOf(servico.getDuracao()));
            etPreco.setText(String.valueOf(servico.getPreco()));
            etPrestadorID.setText(String.valueOf(servico.getPrestador_id()));
            Glide.with(getApplicationContext())
                    .load(R.drawable.logoipl)
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
        if(item.getItemId()==R.id.itemRemover) {
            dialogConfirmRemover();
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
                        /*SingletonBookManager.getInstance(getApplicationContext()).deleteBookBD(book.getId());
                        Intent intent = new Intent();
                        setResult(RESULT_OK, intent);
                        finish();*/
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