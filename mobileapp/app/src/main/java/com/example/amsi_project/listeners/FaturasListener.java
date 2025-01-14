package com.example.amsi_project.listeners;

import com.example.amsi_project.modelo.Fatura;

import java.util.ArrayList;

public interface FaturasListener {
    void onRefreshListaFaturas(ArrayList<Fatura> faturas);
}
