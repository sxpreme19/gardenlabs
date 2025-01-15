package com.example.amsi_project.modelo;

public class Userprofile {
    private int id,user_id;
    private Integer telefone,nif;
    private String nome,morada;

    public Userprofile(int id, String nome, String morada,Integer telefone, Integer nif, int user_id) {
        this.id = id;
        this.telefone = telefone;
        this.nif = nif;
        this.user_id = user_id;
        this.nome = nome;
        this.morada = morada;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public Integer getTelefone() {
        return telefone;
    }

    public void setTelefone(Integer telefone) {
        this.telefone = telefone;
    }

    public Integer getNif() {
        return nif;
    }

    public void setNif(Integer nif) {
        this.nif = nif;
    }

    public int getUser_id() {
        return user_id;
    }

    public void setUser_id(int user_id) {
        this.user_id = user_id;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getMorada() {
        return morada;
    }

    public void setMorada(String morada) {
        this.morada = morada;
    }
}
