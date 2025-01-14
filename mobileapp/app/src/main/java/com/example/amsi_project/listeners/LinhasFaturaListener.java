package com.example.amsi_project.listeners;

import com.example.amsi_project.modelo.Favorito;
import com.example.amsi_project.modelo.Linhafatura;

import java.util.ArrayList;

public interface LinhasFaturaListener {
    void onRefreshListaLinhasFatura(ArrayList<Linhafatura> linhasfatura);
}
