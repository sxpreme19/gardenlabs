package com.example.amsi_project;

import android.os.Bundle;
import android.util.Patterns;
import android.view.View;
import android.content.Intent;
import android.widget.EditText;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;

import com.example.amsi_project.listeners.RegisterListener;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

public class RegisterActivity extends AppCompatActivity implements RegisterListener {

    private EditText etEmail, etPassword,etUsername;
    public static final  int MIN_PASS=8;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_register);

        etEmail=findViewById(R.id.etEmail);
        etPassword=findViewById(R.id.etPassword);
        etUsername=findViewById(R.id.etUsername);
    }

    public void onClickRegister(View view) {
        String username = etUsername.getText().toString();
        String password = etPassword.getText().toString();
        String email = etEmail.getText().toString();

        if(!isUsernameValid(username)){
            etUsername.setError(getString(R.string.txt_username_inval));
            return;
        }

        if (!isEmailValid(email)) {
            etEmail.setError(getString(R.string.txt_email_inval));
            return;
        }

        if (!isPasswrdValid(password)) {
            etPassword.setError(getString(R.string.txt_ncaracteres_insuf));
            return;
        }

        SingletonGardenLabsManager.getInstance(getApplicationContext()).registerAPI(getApplicationContext(),username, password,email);
    }

    public void onClickLoginLink(View view) {
        Intent intent = new Intent(RegisterActivity.this, LoginActivity.class);
        startActivity(intent);
    }

    @Override
    public void onUpdateRegister() {
        Intent intent = new Intent(this, LoginActivity.class);
        startActivity(intent);
    }

    public boolean isUsernameValid(String username) {
        if (username==null)
            return false;
        return !username.isEmpty();
    }

    public boolean isEmailValid(String email) {
        if (email==null)
            return false;
        return Patterns.EMAIL_ADDRESS.matcher(email).matches();
    }


    public boolean isPasswrdValid(String passwrd) {
        if (passwrd==null)
            return false;

        return passwrd.length()>=MIN_PASS;
    }
}