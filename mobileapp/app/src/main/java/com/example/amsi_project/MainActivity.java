package com.example.amsi_project;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

public class MainActivity extends AppCompatActivity {

    private TextView tvEmail;
    private String email;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        tvEmail = findViewById(R.id.tvEmail);
        Intent intent = getIntent();
        if (email!=null)
            tvEmail.setText(email);
        else
            tvEmail.setText(R.string.txt_no_email);
    }

    public void onClickEstatico(View view) {
        Intent intent = new Intent(this, DetalhesEstaticoActivity.class);
        startActivity(intent);
    }

    public void onClickDinamico(View view) {
        Intent intent = new Intent(this, DetalhesDinamicoActivity.class);
        startActivity(intent);
    }

    public void onClickEmail(View view) {
        //TODO intent implicito ACTION_SEND
    }
}