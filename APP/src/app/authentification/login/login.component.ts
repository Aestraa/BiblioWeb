import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms'; // Importez ces éléments
import { Router } from '@angular/router';
import { ApiService } from '../../services/api.service';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
})
export class LoginComponent {
  loginForm: FormGroup;
  loading = false;
  error = false;

  constructor(
    private api: ApiService,
    private auth: AuthService,
    private router: Router
  ) {
    this.loginForm = new FormGroup({
      email: new FormControl('', [Validators.required, Validators.email]),
      password: new FormControl('', [
        Validators.required,
        Validators.minLength(6),
      ]),
    });
  }

  onSubmit() {
    if (this.loginForm.valid) {
      this.loading = true;
      this.api.login({ ...this.loginForm.value }).subscribe(
        (res) => {
          this.loading = false;
          this.auth.token = res.token;
          this.router.navigate(['/']);
        },
        (error) => {
          console.error(error);
          this.loading = false;
          this.error = true; // Mettre à jour la variable de classe en cas d'erreur
        }
      );
    } else {
      console.error('Form is not valid');
    }
  }
}
