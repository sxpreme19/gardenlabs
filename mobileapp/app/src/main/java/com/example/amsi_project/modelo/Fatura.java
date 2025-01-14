package com.example.amsi_project.modelo;

import android.util.Log;

import java.util.Date;

public class Fatura {
    int id,telefone_destinatario,nif_destinatario,metodopagamento_id,userprofile_id;
    String nome_destinatario,morada_destinatario;
    double total;
    Date datahora;

    public Fatura(int id,Double total, Date datahora, String nome_destinatario, String morada_destinatario, int telefone_destinatario, int nif_destinatario, int metodopagamento_id, int userprofile_id) {
        this.id = id;
        this.telefone_destinatario = telefone_destinatario;
        this.nif_destinatario = nif_destinatario;
        this.metodopagamento_id = metodopagamento_id;
        this.userprofile_id = userprofile_id;
        this.nome_destinatario = nome_destinatario;
        this.morada_destinatario = morada_destinatario;
        this.total = total;
        this.datahora = datahora;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getTelefone_destinatario() {
        return telefone_destinatario;
    }

    public void setTelefone_destinatario(int telefone_destinatario) {
        this.telefone_destinatario = telefone_destinatario;
    }

    public int getNif_destinatario() {
        return nif_destinatario;
    }

    public void setNif_destinatario(int nif_destinatario) {
        this.nif_destinatario = nif_destinatario;
    }

    public int getMetodopagamento_id() {
        return metodopagamento_id;
    }

    public void setMetodopagamento_id(int metodopagamento_id) {
        this.metodopagamento_id = metodopagamento_id;
    }

    public int getUserprofile_id() {
        return userprofile_id;
    }

    public void setUserprofile_id(int userprofile_id) {
        this.userprofile_id = userprofile_id;
    }

    public String getNome_destinatario() {
        return nome_destinatario;
    }

    public void setNome_destinatario(String nome_destinatario) {
        this.nome_destinatario = nome_destinatario;
    }

    public String getMorada_destinatario() {
        return morada_destinatario;
    }

    public void setMorada_destinatario(String morada_destinatario) {
        this.morada_destinatario = morada_destinatario;
    }

    public Double getTotal() {
        return total;
    }

    public void setTotal(Double total) {
        this.total = total;
    }

    public Date getDatahora() {
        return datahora;
    }

    public void setDatahora(Date datahora) {
        this.datahora = datahora;
    }
}
