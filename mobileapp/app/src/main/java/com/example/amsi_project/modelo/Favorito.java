package com.example.amsi_project.modelo;

public class Favorito {
    int id,userprofile_id,servico_id;

    public Favorito(int id, int userprofile_id, int servico_id) {
        this.id = id;
        this.userprofile_id = userprofile_id;
        this.servico_id = servico_id;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getUserprofile_id() {
        return userprofile_id;
    }

    public void setUserprofile_id(int userprofile_id) {
        this.userprofile_id = userprofile_id;
    }

    public int getServico_id() {
        return servico_id;
    }

    public void setServico_id(int servico_id) {
        this.servico_id = servico_id;
    }
}
