package com.example.amsi_project.modelo;

import java.util.Date;

public class Review {
    int id,servico_id,userprofile_id;
    double avaliacao;
    Date datahora;
    String conteudo;

    public Review(int id, String conteudo, Date datahora,double avaliacao, int servico_id, int userprofile_id ) {
        this.id = id;
        this.servico_id = servico_id;
        this.userprofile_id = userprofile_id;
        this.avaliacao = avaliacao;
        this.datahora = datahora;
        this.conteudo = conteudo;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getServico_id() {
        return servico_id;
    }

    public void setServico_id(int servico_id) {
        this.servico_id = servico_id;
    }

    public int getUserprofile_id() {
        return userprofile_id;
    }

    public void setUserprofile_id(int userprofile_id) {
        this.userprofile_id = userprofile_id;
    }

    public double getAvaliacao() {
        return avaliacao;
    }

    public void setAvaliacao(double avaliacao) {
        this.avaliacao = avaliacao;
    }

    public Date getDatahora() {
        return datahora;
    }

    public void setDatahora(Date datahora) {
        this.datahora = datahora;
    }

    public String getConteudo() {
        return conteudo;
    }

    public void setConteudo(String conteudo) {
        this.conteudo = conteudo;
    }
}
