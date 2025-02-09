package com.example.amsi_project;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ListView;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.amsi_project.adaptadores.ListaLinhasFaturaAdaptador;
import com.example.amsi_project.listeners.FaturaListener;
import com.example.amsi_project.listeners.LinhasFaturaListener;
import com.example.amsi_project.modelo.Linhafatura;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Locale;

public class DetalhesFaturaActivity extends AppCompatActivity implements FaturaListener, LinhasFaturaListener {

    private TextView tvInvoiceTitle,tvInvoiceDate,tvInvoiceName,tvInvoiceEmail,tvInvoiceAddress,tvInvoicePhone,tvInvoiceNif,tvInvoicePaymentMethod,tvInvoiceTotal,tvPhonelbl,tvNiflbl,tvInvoiceSubtotal, tvInvoiceIVA;
    private ListView lvInvoiceLines;
    int faturaid;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_detalhes_fatura);
        setTitle("Invoice Details");

        faturaid=getIntent().getIntExtra("ID", 0);

        tvInvoiceTitle = findViewById(R.id.tvInvoiceTitle);
        tvInvoiceDate = findViewById(R.id.tvInvoiceDate);
        tvInvoiceName = findViewById(R.id.tvBillingName);
        tvInvoiceEmail = findViewById(R.id.tvBillingEmail);
        tvInvoiceAddress = findViewById(R.id.tvBillingAddress);
        tvInvoicePhone = findViewById(R.id.tvBillingPhone);
        tvInvoiceNif = findViewById(R.id.tvBillingNif);
        lvInvoiceLines = findViewById(R.id.lvLinhasFatura);
        tvInvoicePaymentMethod = findViewById(R.id.tvPaymentMethod);
        tvInvoiceTotal = findViewById(R.id.tvInvoiceTotal);
        tvPhonelbl = findViewById(R.id.tvBillingPhoneLabel);
        tvNiflbl = findViewById(R.id.tvBillingNifLabel);
        tvInvoiceSubtotal = findViewById(R.id.tvInvoiceSubtotal);
        tvInvoiceIVA = findViewById(R.id.tvInvoiceIVA);

        SingletonGardenLabsManager.getInstance(getApplicationContext()).setLinhasFaturaListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).setFaturaListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).getFaturaAPI(faturaid,getApplicationContext());
    }

    @Override
    public void onRefreshDetalhes(int id, double total, Date datahora, String nome_destinatario, String morada_destinatario, Integer telefone_destinatario, Integer nif_destinatario, String metodopagamento) {
        faturaid = id;
        tvInvoiceTitle.setText("Invoice #" + id);
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss", Locale.getDefault());
        String formattedDate = sdf.format(datahora);
        tvInvoiceDate.setText(formattedDate);
        tvInvoiceName.setText(nome_destinatario);
        tvInvoiceEmail.setText(getEmailFromSharedPreferences(getApplicationContext()));
        tvInvoiceAddress.setText(morada_destinatario);
        if(telefone_destinatario != null && telefone_destinatario != 0){
            tvInvoicePhone.setText(String.valueOf(telefone_destinatario));
            tvInvoicePhone.setVisibility(View.VISIBLE);
            tvPhonelbl.setVisibility(View.VISIBLE);
        }
        if(nif_destinatario != null && nif_destinatario != 0){
            tvInvoiceNif.setText(String.valueOf(nif_destinatario));
            tvInvoiceNif.setVisibility(View.VISIBLE);
            tvNiflbl.setVisibility(View.VISIBLE);
        }

        tvInvoicePaymentMethod.setText(metodopagamento);

        double ivaRate = 0.23;
        double subtotal = total / (1 + ivaRate);
        double iva = total - subtotal;

        tvInvoiceSubtotal.setText(subtotal + "€");
        tvInvoiceIVA.setText(iva + "€");
        tvInvoiceTotal.setText(total + "€");
    }

    @Override
    public void onRefreshListaLinhasFatura(ArrayList<Linhafatura> linhasfatura) {
        if(linhasfatura != null){
            lvInvoiceLines.setAdapter(new ListaLinhasFaturaAdaptador(linhasfatura,getApplicationContext()));
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        if(String.valueOf(faturaid)!=null) {
            getMenuInflater().inflate(R.menu.menu_goback,menu);
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

    public String getEmailFromSharedPreferences(Context context) {
        SharedPreferences sharedPref = context.getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        return sharedPref.getString("email", null);  // Return the token, or null if not found
    }
}