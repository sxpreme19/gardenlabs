package com.example.amsi_project;

import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.amsi_project.adaptadores.ListaLinhasCarrinhoAdaptador;
import com.example.amsi_project.adaptadores.SpinnerMetodosPagamentoAdaptador;
import com.example.amsi_project.listeners.CartLinesListener;
import com.example.amsi_project.listeners.CartListener;
import com.example.amsi_project.listeners.MetodosPagamentoListener;
import com.example.amsi_project.listeners.UserProfileListener;
import com.example.amsi_project.modelo.Linhacarrinhoservico;
import com.example.amsi_project.modelo.Metodopagamento;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

import java.util.ArrayList;

public class CheckoutActivity extends AppCompatActivity implements CartListener, CartLinesListener, MetodosPagamentoListener, UserProfileListener {

    private Spinner spMetodosPagamento;
    private ListView listaLinhascarrinho;
    private TextView tvTotal;
    private EditText etNome,etMorada,etTelefone,etNIF;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_checkout);
        setTitle("Checkout");

        listaLinhascarrinho = findViewById(R.id.lvLinhasCarrinho);
        tvTotal = findViewById(R.id.tvTotal);
        spMetodosPagamento = findViewById(R.id.spMetodoPagamento);
        etNome = findViewById(R.id.etNome);
        etMorada = findViewById(R.id.etMorada);
        etTelefone = findViewById(R.id.etTelefone);
        etNIF = findViewById(R.id.etNIF);

        SingletonGardenLabsManager.getInstance(getApplicationContext()).setUserProfileListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).setMetodosPagamentoListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).setCartListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).setCartLinesListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).getCartAPI(getApplicationContext());
        SingletonGardenLabsManager.getInstance(getApplicationContext()).getCartLinesAPI(getApplicationContext());
        SingletonGardenLabsManager.getInstance(getApplicationContext()).getMetodosPagamentoAPI(getApplicationContext());
        SingletonGardenLabsManager.getInstance(getApplicationContext()).getUserProfileAPI(getApplicationContext());
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_goback,menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        if(item.getItemId()==R.id.itemGoBack) {
            finish();
            return super.onOptionsItemSelected(item);
        }
        return false;
    }

    @Override
    public void onRefreshDetalhes(Double total) {
        tvTotal.setText("Total: " + total + "€");
    }

    @Override
    public void onRefreshListaLinhasCarrinho(ArrayList<Linhacarrinhoservico> listLinhasCarrinho) {
        if(listLinhasCarrinho != null){
            listaLinhascarrinho.setAdapter(new ListaLinhasCarrinhoAdaptador(listLinhasCarrinho,getApplicationContext()));
        }
    }

    @Override
    public void onRefreshMetodosPagamento(ArrayList<Metodopagamento> metodospagamento) {
        if(metodospagamento != null){
            spMetodosPagamento.setAdapter(new SpinnerMetodosPagamentoAdaptador(metodospagamento,getApplicationContext()));
        }
    }

    @Override
    public void onRefreshDetalhes(String nome, String morada, int telefone, int nif) {
        etNome.setText(nome);
        etMorada.setText(morada);
        etTelefone.setText(String.valueOf(telefone));
        etNIF.setText(String.valueOf(nif));
    }
}