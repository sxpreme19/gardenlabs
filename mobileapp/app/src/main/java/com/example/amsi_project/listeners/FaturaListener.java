package com.example.amsi_project.listeners;

import java.util.Date;

public interface FaturaListener {
    void onRefreshDetalhes(int id,double total, Date datahora,String nome_destinatario,String morada_destinatario,Integer telefone_destinatario,Integer nif_destinatario,String metodopagamento);
}
