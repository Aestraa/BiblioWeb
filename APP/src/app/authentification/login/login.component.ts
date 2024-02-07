import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms'; // Importez ces éléments
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

  constructor(
    private http: HttpClient,
    private api: ApiService,
    private auth: AuthService
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
        (user) => {
          this.loading = false;
          console.log('User logged in', user);
        },
        (error) => {
          console.error(error);
          this.loading = false;
        }
      );
      this.loading = false;
    } else {
      console.error('Form is not valid');
    }
  }
}
