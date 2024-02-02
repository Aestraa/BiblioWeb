import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms'; // Importez ces éléments

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
})
export class LoginComponent {
  loginForm = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email]), // Ajoutez des validateurs
    password: new FormControl('', [
      Validators.required,
      Validators.minLength(6),
    ]),
  });
  loading = false;

  constructor(private http: HttpClient) {}

  onSubmit() {
    if (this.loginForm.valid) {
      this.loading = true;
      console.log('Form Value:', this.loginForm.value);
      // this.http.post('URL_DE_VOTRE_API', this.loginForm.value).subscribe(
      //   response => {
      //     console.log('Success!', response);
      //     // Gérez la réponse ici
      //   },
      //   error => {
      //     console.error('Error!', error);
      //     // Gérez les erreurs ici
      //   }
      // );
      this.loading = false;
    } else {
      console.error('Form is not valid');
    }
  }
}
