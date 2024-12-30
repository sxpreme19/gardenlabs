package com.example.amsi_project;

import android.os.Bundle;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

public class DetalhesEstaticoActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhes_estatico);

        setTitle(getString(R.string.txt_daestaticos));

        ImageView imgCapa=findViewById(R.id.imgCapa);
        TextView tvTitulo=findViewById(R.id.tvTitulo);
        TextView tvSerie=findViewById(R.id.tvSerie);
        TextView tvAutor=findViewById(R.id.tvAutor);
        TextView tvAno=findViewById(R.id.tvAno);

        tvTitulo.setText("Programar Android em AMSI");
        tvSerie.setText("Android Saga");
        tvAutor.setText("Equipa AMSI");
        tvAno.setText("2019");
        imgCapa.setImageResource(R.drawable.programarandroid1);

    }
}