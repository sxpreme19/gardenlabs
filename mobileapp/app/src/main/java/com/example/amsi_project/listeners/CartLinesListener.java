package com.example.amsi_project.listeners;

import com.example.amsi_project.modelo.Linhacarrinhoservico;
import com.example.amsi_project.modelo.Servico;

import java.util.ArrayList;

public interface CartLinesListener {
    void onRefreshListaLinhasCarrinho(ArrayList<Linhacarrinhoservico> listaLinhasCarrinho);
}
