package com.example.amsi_project;

import android.content.DialogInterface;
import android.os.Bundle;
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
import com.example.amsi_project.listeners.LivroListener;
import com.example.amsi_project.modelo.Book;
import com.example.amsi_project.modelo.SingletonBookManager;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

public class DetalhesLivroActivity extends AppCompatActivity implements LivroListener {

    public static final String DEFAULT_IMG = "http://amsi.dei.estg.ipleiria.pt/img/ipl_semfundo.png";
    private EditText etTitulo, etSerie, etAutor, etAno;
    private ImageView imgCapa;
    private FloatingActionButton fabDetalhes;
    private Book book;
    public static final int MIN_CHAR=3, MIN_NUMBER=4;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhes_livro);

        int id=getIntent().getIntExtra("ID", 0);
        book = SingletonBookManager.getInstance(getApplicationContext()).getBook(id);
        etTitulo=findViewById(R.id.etTitulo);
        etSerie=findViewById(R.id.etSerie);
        etAutor=findViewById(R.id.etAutor);
        etAno=findViewById(R.id.etAno);
        imgCapa=findViewById(R.id.imgCapa);
        fabDetalhes=findViewById(R.id.fabDetalhes);
        if (book != null)
            carregarLivros();
        else setTitle("Novo livro");

        SingletonBookManager.getInstance(getApplicationContext()).setLivroListener(this);

        fabDetalhes.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(isLivroValid()) {
                    if(book!=null) {
                        book.setTitulo(etTitulo.getText().toString());
                        book.setSerie(etSerie.getText().toString());
                        book.setAutor(etAutor.getText().toString());
                        book.setAno(Integer.parseInt(etAno.getText().toString()));
                        /*SingletonBookManager.getInstance(getApplicationContext()).editBookBD(book);
                        Intent intent = new Intent();
                        setResult(RESULT_OK, intent);
                        finish();*/
                        SingletonBookManager.getInstance(getApplicationContext()).editarLivroAPI(book, getApplicationContext());
                    }
                    else {
                        book = new Book(0,DEFAULT_IMG, Integer.parseInt(etAno.getText().toString()),
                                etTitulo.getText().toString(), etSerie.getText().toString(),
                                etAutor.getText().toString());
                        /*SingletonBookManager.getInstance(getApplicationContext()).addBookBD(book);
                        Intent intent = new Intent();
                        setResult(RESULT_OK, intent);
                        finish();*/
                        SingletonBookManager.getInstance(getApplicationContext()).adicionarLivroAPI(book, getApplicationContext());
                    }
                }
            }
        });
    }

    private boolean isLivroValid() {
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
    }

    private void carregarLivros() {
//        ArrayList<Book> books = SingletonBookManager.getInstance().getBooks();
//        if(books.size()>0) {
//            Book book = books.get(0); 
            etTitulo.setText(book.getTitulo());
            etSerie.setText(book.getSerie());
            etAutor.setText(book.getAutor());
            etAno.setText(book.getAno() + "");
            //imgCapa.setImageResource(book.getCapa());
            Glide.with(getApplicationContext())
                .load(book.getCapa())
                .placeholder(R.drawable.logoipl)
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .into(imgCapa);
        
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        if(book!=null) {
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
                        SingletonBookManager.getInstance(getApplicationContext()).removerLivroAPI(book, getApplicationContext());
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