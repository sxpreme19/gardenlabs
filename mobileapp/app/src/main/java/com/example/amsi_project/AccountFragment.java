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
import com.example.amsi_project.modelo.BDHelper;
import com.example.amsi_project.modelo.Servico;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;
import com.example.amsi_project.modelo.User;
import com.example.amsi_project.modelo.Userprofile;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import java.util.ArrayList;

public class AccountFragment extends Fragment implements UserListener, UserProfileListener {

    private BDHelper bdHelper;
    private FloatingActionButton fabUpdate,fabDelete;
    private EditText etUsername,etEmail,etNome,etMorada,etTelefone,etNif;
    private User user;
    private Userprofile userprofile;
    private static final int MANDATORY=9;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_account, container, false);

        bdHelper = new BDHelper(getContext());

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

                if(!updatedUsername.equals(user.getUsername())){
                    if (bdHelper.isUserUsernameExists(updatedUsername)) {
                        Toast.makeText(getContext(), "Username inválido!", Toast.LENGTH_LONG).show();
                        return;
                    }
                }
                user.setUsername(updatedUsername);

                if(!updatedEmail.equals(user.getEmail())){
                    if (bdHelper.isUserEmailExists(updatedEmail)) {
                        Toast.makeText(getContext(), "Email inválido!", Toast.LENGTH_LONG).show();
                        return;
                    }
                }
                user.setEmail(updatedEmail);

                userprofile.setNome(updatedNome.isEmpty() ? null : updatedNome);
                userprofile.setMorada(updatedMorada.isEmpty() ? null : updatedMorada);

                if (!updatedTelefone.isEmpty()) {
                    if (updatedTelefone.length() != MANDATORY) {
                        Toast.makeText(getContext(), "O número de telefone deve conter 9 dígitos!", Toast.LENGTH_LONG).show();
                        return;
                    }
                    userprofile.setTelefone(Integer.parseInt(updatedTelefone));
                } else {
                    userprofile.setTelefone(null);
                }

                if (!updatedNif.isEmpty()) {
                    if (updatedNif.length() != MANDATORY) {
                        Toast.makeText(getContext(), "O NIF deve conter 9 dígitos!", Toast.LENGTH_LONG).show();
                        return;
                    }
                    userprofile.setNif(Integer.parseInt(updatedNif));
                } else {
                    userprofile.setNif(null);
                }

                Log.d("UserProfilePayload", "Username: " + user.getUsername() + ", Email: " + user.getEmail() +
                        ", Nome: " + userprofile.getNome() + ", Morada: " + userprofile.getMorada() +
                        ", Telefone: " + userprofile.getTelefone() + ", NIF: " + userprofile.getNif());

                SingletonGardenLabsManager.getInstance(getContext()).editarUserAPI(user, getContext());
                SingletonGardenLabsManager.getInstance(getContext()).editarUserProfileAPI(userprofile, getContext());
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
    public void onRefreshDetalhes(String nome, String morada, Integer telefone, Integer nif) {
        etNome.setText(isNullOrEmpty(nome) ? "" : nome);
        etMorada.setText(isNullOrEmpty(morada) ? "" : morada);
        etTelefone.setText(telefone == null ? "" : String.valueOf(telefone));
        etNif.setText(nif == null ? "" : String.valueOf(nif));
    }

    private boolean isNullOrEmpty(String value) {
        return value == null || value.equalsIgnoreCase("null") || value.isEmpty();
    }


}
