package com.example.amsi_project;

import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.TextureView;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.Toast;

import com.example.amsi_project.adaptadores.ListaServicosAdaptador;
import com.example.amsi_project.listeners.UserListener;
import com.example.amsi_project.listeners.UserProfileListener;
import com.example.amsi_project.modelo.Servico;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;
import com.example.amsi_project.modelo.User;
import com.example.amsi_project.modelo.Userprofile;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import java.util.ArrayList;

public class AccountFragment extends Fragment implements UserListener, UserProfileListener {

    private FloatingActionButton fabUpdate,fabDelete;
    private EditText etUsername,etEmail,etNome,etMorada,etTelefone,etNif;
    private User user;
    private Userprofile userprofile;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_account, container, false);

        SingletonGardenLabsManager.getInstance(getContext()).setUserListener(this);
        SingletonGardenLabsManager.getInstance(getContext()).setUserProfileListener(this);
        SingletonGardenLabsManager.getInstance(getContext()).getUserAPI(getContext());
        SingletonGardenLabsManager.getInstance(getContext()).getUserProfileAPI(getContext());

        SharedPreferences sharedPref = getContext().getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        int userId = sharedPref.getInt("id", -1);
        int userprofileId = sharedPref.getInt("profileid",-1);

        user = SingletonGardenLabsManager.getInstance(getContext()).getUser(userId);
        userprofile = SingletonGardenLabsManager.getInstance(getContext()).getUserProfile(userprofileId);
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
                String updatedNome = etNome.getText().toString();
                String updatedMorada = etMorada.getText().toString();
                String updatedTelefone = etTelefone.getText().toString();
                String updatedNif = etNif.getText().toString();

                user.setUsername(updatedUsername);
                user.setEmail(updatedEmail);

                userprofile.setNome(updatedNome);
                userprofile.setMorada(updatedMorada);
                userprofile.setTelefone(Integer.parseInt(updatedTelefone));
                userprofile.setNif(Integer.parseInt(updatedNif));


                SingletonGardenLabsManager.getInstance(getContext()).editarUserAPI(user,getContext());
                SingletonGardenLabsManager.getInstance(getContext()).editarUserProfileAPI(userprofile,getContext());
                Toast.makeText(getContext(), "Atualizado!", Toast.LENGTH_LONG).show();
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
