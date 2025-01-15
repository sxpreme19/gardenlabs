package com.example.amsi_project;

import android.annotation.SuppressLint;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;

import com.example.amsi_project.adaptadores.ListaLinhasFaturaAdaptador;
import com.example.amsi_project.listeners.FaturaListener;
import com.example.amsi_project.listeners.LinhasFaturaListener;
import com.example.amsi_project.modelo.BDHelper;
import com.example.amsi_project.modelo.Linhafatura;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Locale;

public class PurchaseActivity extends AppCompatActivity implements FaturaListener, LinhasFaturaListener {

    private TextView tvInvoiceTitle,tvInvoiceDate,tvInvoiceName,tvInvoiceEmail,tvInvoiceAddress,tvInvoicePhone,tvInvoiceNif,tvInvoicePaymentMethod,tvInvoiceTotal,tvPhonelbl,tvNiflbl;
    private ListView lvInvoiceLines;
    private Button btnBackToShop;
    int faturaid;
    BDHelper bdHelper;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_purchase);
        setTitle("Purchase Confirmed");

        bdHelper = new BDHelper(getApplicationContext());
        faturaid = bdHelper.getLatestFaturaId();

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
        btnBackToShop = findViewById(R.id.btnBackToShop);
        tvPhonelbl = findViewById(R.id.tvBillingPhoneLabel);
        tvNiflbl = findViewById(R.id.tvBillingNifLabel);

        SingletonGardenLabsManager.getInstance(getApplicationContext()).setLinhasFaturaListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).setFaturaListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).getFaturaAPI(faturaid,getApplicationContext());

        btnBackToShop.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(getApplicationContext(), MenuMainActivity.class);
                startActivity(intent);
            }
        });
    }

    @Override
    public void onRefreshDetalhes(int id,double total, Date datahora, String nome_destinatario, String morada_destinatario, Integer telefone_destinatario, Integer nif_destinatario, String metodopagamento) {
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
        tvInvoiceTotal.setText(total+"€");

    }

    @Override
    public void onRefreshListaLinhasFatura(ArrayList<Linhafatura> linhasfatura) {
        if(linhasfatura != null){
            lvInvoiceLines.setAdapter(new ListaLinhasFaturaAdaptador(linhasfatura,getApplicationContext()));
        }
    }

    public String getEmailFromSharedPreferences(Context context) {
        SharedPreferences sharedPref = context.getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        return sharedPref.getString("email", null);  // Return the token, or null if not found
    }
}