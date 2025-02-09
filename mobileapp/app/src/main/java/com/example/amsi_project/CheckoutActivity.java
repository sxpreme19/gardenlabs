package com.example.amsi_project;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
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
import com.example.amsi_project.modelo.BDHelper;
import com.example.amsi_project.modelo.Fatura;
import com.example.amsi_project.modelo.Linhacarrinhoservico;
import com.example.amsi_project.modelo.Linhafatura;
import com.example.amsi_project.modelo.Metodopagamento;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

import java.util.ArrayList;
import java.util.Date;

public class CheckoutActivity extends AppCompatActivity implements CartListener, CartLinesListener, MetodosPagamentoListener, UserProfileListener {

    private BDHelper bdHelper;
    private Spinner spMetodosPagamento;
    private ListView listaLinhascarrinho;
    private TextView tvSubtotal,tvIva,tvTotal;
    private EditText etNome,etMorada,etTelefone,etNIF;
    private Button btnConfirmPurchase;
    private ArrayList<Linhacarrinhoservico> linhascarrinhoservico;
    private double total;
    private static final int MANDATORY=9;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_checkout);
        setTitle("Checkout");

        bdHelper = new BDHelper(getApplicationContext());
        linhascarrinhoservico = new ArrayList<>();

        listaLinhascarrinho = findViewById(R.id.lvLinhasCarrinho);
        tvSubtotal = findViewById(R.id.tvSubtotal);
        tvIva = findViewById(R.id.tvIVA);
        tvTotal = findViewById(R.id.tvTotal);
        spMetodosPagamento = findViewById(R.id.spMetodoPagamento);
        etNome = findViewById(R.id.etNome);
        etMorada = findViewById(R.id.etMorada);
        etTelefone = findViewById(R.id.etTelefone);
        etNIF = findViewById(R.id.etNIF);
        btnConfirmPurchase = findViewById(R.id.btnConfirmarCompra);

        SingletonGardenLabsManager.getInstance(getApplicationContext()).setUserProfileListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).setMetodosPagamentoListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).setCartListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).setCartLinesListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).getCartAPI(getApplicationContext());
        SingletonGardenLabsManager.getInstance(getApplicationContext()).getCartLinesAPI(getApplicationContext());
        SingletonGardenLabsManager.getInstance(getApplicationContext()).getMetodosPagamentoAPI(getApplicationContext());
        SingletonGardenLabsManager.getInstance(getApplicationContext()).getUserProfileAPI(getApplicationContext());

        btnConfirmPurchase.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(etNome.length() < 1 && etNome != null){
                    etNome.setError(getString(R.string.txt_form_error_field_empty));
                    return;
                }
                if(etMorada.length() < 1 && etMorada != null){
                    etMorada.setError(getString(R.string.txt_form_error_field_empty));
                    return;
                }

                String nome = etNome.getText().toString();
                String morada = etMorada.getText().toString();
                Integer telefone = null;
                Integer nif = null;

                if (etTelefone.length() == MANDATORY) {
                    try {
                        telefone = Integer.parseInt(etTelefone.getText().toString());
                    } catch (NumberFormatException e) {
                        etTelefone.setError(getString(R.string.txt_form_error_field_empty));
                        return;
                    }
                }

                if (etNIF.length() == MANDATORY) {
                    try {
                        nif = Integer.parseInt(etNIF.getText().toString());
                    } catch (NumberFormatException e) {
                        etNIF.setError(getString(R.string.txt_form_error_field_empty));
                        return;
                    }
                }

                Metodopagamento selectedMetodo = (Metodopagamento) spMetodosPagamento.getSelectedItem();

                linhascarrinhoservico = bdHelper.getCartLinesBD(getCartIDFromSharedPreferences(getApplicationContext()));

                SingletonGardenLabsManager.getInstance(getApplicationContext()).adicionarFaturaAPI(total,nome,morada,telefone,nif,selectedMetodo.getId(),linhascarrinhoservico,getApplicationContext());
                for (Linhacarrinhoservico l : linhascarrinhoservico){
                    SingletonGardenLabsManager.getInstance(getApplicationContext()).removerCartLineAPI(l,getApplicationContext());
                }

                Intent intent = new Intent(getApplicationContext(), PurchaseActivity.class);
                startActivity(intent);

            }
        });
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
        double ivaRate = 0.23;
        double ivaAmount = total * ivaRate;
        double totalWithIVA = total + ivaAmount;

        TextView tvSubtotal = findViewById(R.id.tvSubtotal);
        TextView tvIVA = findViewById(R.id.tvIVA);
        TextView tvTotal = findViewById(R.id.tvTotal);

        tvSubtotal.setText("Subtotal: " + total + "€");
        tvIVA.setText("IVA (23%): " + ivaAmount + "€");
        tvTotal.setText("Total: " + totalWithIVA + "€");

        this.total = totalWithIVA;
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
    public void onRefreshDetalhes(String nome, String morada, Integer telefone, Integer nif) {
        etNome.setText(isNullOrEmpty(nome) ? "" : nome);
        etMorada.setText(isNullOrEmpty(morada) ? "" : morada);
        etTelefone.setText(telefone == null ? "" : String.valueOf(telefone));
        etNIF.setText(nif == null ? "" : String.valueOf(nif));
    }

    private boolean isNullOrEmpty(String value) {
        return value == null || value.equalsIgnoreCase("null") || value.isEmpty();
    }


    public int getCartIDFromSharedPreferences(Context context) {
        SharedPreferences sharedPref = context.getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        int cartID = sharedPref.getInt("servicecartid", -1);
        return cartID;
    }

}