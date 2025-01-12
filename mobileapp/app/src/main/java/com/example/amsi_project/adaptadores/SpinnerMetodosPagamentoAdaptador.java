package com.example.amsi_project.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.example.amsi_project.R;
import com.example.amsi_project.modelo.Metodopagamento;

import java.util.ArrayList;

public class SpinnerMetodosPagamentoAdaptador extends BaseAdapter {

    private Context context;
    private ArrayList<Metodopagamento> metodoPagamentos;

    public SpinnerMetodosPagamentoAdaptador(ArrayList<Metodopagamento> metodoPagamentos, Context context) {
        this.metodoPagamentos = metodoPagamentos;
        this.context = context;
    }

    @Override
    public int getCount() {
        return metodoPagamentos.size();
    }

    @Override
    public Object getItem(int position) {
        return metodoPagamentos.get(position);
    }

    @Override
    public long getItemId(int position) {
        return metodoPagamentos.get(position).getId();
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (convertView == null) {
            convertView = LayoutInflater.from(context).inflate(android.R.layout.simple_spinner_item, parent, false);
        }

        TextView textView = convertView.findViewById(android.R.id.text1);
        Metodopagamento metodoPagamento = metodoPagamentos.get(position);

        textView.setText(metodoPagamento.getDescricao());

        return convertView;
    }

    @Override
    public View getDropDownView(int position, View convertView, ViewGroup parent) {
        if (convertView == null) {
            convertView = LayoutInflater.from(context).inflate(android.R.layout.simple_spinner_dropdown_item, parent, false);
        }

        TextView textView = convertView.findViewById(android.R.id.text1);
        Metodopagamento metodoPagamento = metodoPagamentos.get(position);

        textView.setText(metodoPagamento.getDescricao());

        return convertView;
    }
}
