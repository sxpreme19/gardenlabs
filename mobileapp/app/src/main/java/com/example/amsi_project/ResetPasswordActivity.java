package com.example.amsi_project;

import android.content.Intent;
import android.os.Bundle;
import android.util.Patterns;
import android.view.View;
import android.widget.EditText;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.amsi_project.listeners.LoginListener;
import com.example.amsi_project.listeners.ResetPasswordListener;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

public class ResetPasswordActivity extends AppCompatActivity implements ResetPasswordListener {

    private EditText etEmail, etOldPassword,etNewPassword,etConfirmPassword;
    public static final  int MIN_PASS=8;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_reset_password);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        SingletonGardenLabsManager.getInstance(getApplicationContext()).setResetPasswordListener(this);

        etEmail=findViewById(R.id.etEmail);
        etOldPassword=findViewById(R.id.etOldPassword);
        etNewPassword=findViewById(R.id.etNewPassword);
        etConfirmPassword=findViewById(R.id.etConfirmPassword);
    }

    public void onClickResetPassword(View view) {
        String email = etEmail.getText().toString();
        String oldpassword = etOldPassword.getText().toString();
        String newpassword = etNewPassword.getText().toString();
        String confirmpassword = etConfirmPassword.getText().toString();

        if (!isEmailValid(email)) {
            etEmail.setError(getString(R.string.txt_email_inval));
            return;
        }

        if (!isPasswrdValid(oldpassword)) {
            etOldPassword.setError(getString(R.string.txt_ncaracteres_insuf));
            return;
        }

        if (!isPasswrdValid(newpassword)) {
            etNewPassword.setError(getString(R.string.txt_ncaracteres_insuf));
            return;
        }

        if (!isPasswrdValid(confirmpassword)) {
            etConfirmPassword.setError(getString(R.string.txt_ncaracteres_insuf));
            return;
        } else if (!confirmpassword.equals(newpassword)) {
            etNewPassword.setError(getString(R.string.txt_n_correspondem));
            etConfirmPassword.setError(getString(R.string.txt_n_correspondem));
            return;
        }

        SingletonGardenLabsManager.getInstance(getApplicationContext()).resetpasswordAPI(getApplicationContext(),email,oldpassword,newpassword);

    }

    public void onClickBackToLogin(View view) {
        Intent intent = new Intent(this, LoginActivity.class);
        startActivity(intent);
    }

    @Override
    public void onUpdateResetPassword() {
        Intent intent = new Intent(this, LoginActivity.class);
        startActivity(intent);
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