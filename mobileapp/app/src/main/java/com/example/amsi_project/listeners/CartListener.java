package com.example.amsi_project.listeners;

import com.example.amsi_project.modelo.Linhacarrinhoservico;

import java.util.ArrayList;

public interface CartListener {
    void onRefreshDetalhes(Double total);

    void onRefreshListaLinhasCarrinho(ArrayList<Linhacarrinhoservico> listLinhasCarrinho);
}
