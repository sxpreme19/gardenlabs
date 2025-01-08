package com.example.amsi_project;

import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.TextureView;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;

import com.example.amsi_project.adaptadores.ListaServicosAdaptador;
import com.example.amsi_project.listeners.UserListener;
import com.example.amsi_project.listeners.UserProfileListener;
import com.example.amsi_project.modelo.Servico;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;
import com.example.amsi_project.modelo.User;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import java.util.ArrayList;

public class AccountFragment extends Fragment implements UserListener, UserProfileListener {

    private FloatingActionButton fabUpdate,fabDelete;
    private EditText etUsername,etEmail,etNome,etMorada,etTelefone,etNif;
    private User user;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_account, container, false);

        SharedPreferences sharedPref = getContext().getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        int userId = sharedPref.getInt("id", -1);

        user = SingletonGardenLabsManager.getInstance(getContext()).getUser(userId);
        Log.d("ID", String.valueOf(user));
        etUsername = view.findViewById(R.id.etUsername);
        etEmail = view.findViewById(R.id.etEmail);
        etNome = view.findViewById(R.id.etNome);
        etMorada = view.findViewById(R.id.etMorada);
        etTelefone = view.findViewById(R.id.etTelefone);
        etNif = view.findViewById(R.id.etNIF);

        fabUpdate = view.findViewById(R.id.fabUpdate);
        fabUpdate.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String updatedUsername = etUsername.getText().toString();
                String updatedEmail = etEmail.getText().toString();

                user.setUsername(updatedUsername);
                user.setEmail(updatedEmail);

                SingletonGardenLabsManager.getInstance(getContext()).editarUserAPI(user,getContext());
            }
        });

        fabDelete = view.findViewById(R.id.fabDelete);
        fabDelete.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                new AlertDialog.Builder(getContext())
                        .setTitle("Delete Account")
                        .setMessage("Are you sure you want to delete this account? This action cannot be undone.")
                        .setPositiveButton("Yes", (dialog, which) -> {
                            // Perform delete operation
                            SingletonGardenLabsManager.getInstance(getContext()).removerUserAPI(getContext());
                        })
                        .setNegativeButton("No", (dialog, which) -> {
                            // Dismiss the dialog
                            dialog.dismiss();
                        })
                        .show();
            }
        });

        SingletonGardenLabsManager.getInstance(getContext()).setUserListener(this);
        SingletonGardenLabsManager.getInstance(getContext()).setUserProfileListener(this);
        SingletonGardenLabsManager.getInstance(getContext()).getUserAPI(getContext());
        SingletonGardenLabsManager.getInstance(getContext()).getUserProfileAPI(getContext());

        return view;
    }

    @Override
    public void onRefreshDetalhes(String username, String email) {
        etUsername.setText(username);
        etEmail.setText(email);
    }

    @Override
    public void onRefreshDetalhes(String nome, String morada, int telefone, int nif) {
        etNome.setText(nome);
        etMorada.setText(morada);
        etTelefone.setText(String.valueOf(telefone));
        etNif.setText(String.valueOf(nif));
    }
}
