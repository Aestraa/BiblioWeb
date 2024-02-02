import { Component } from '@angular/core';
import {
  AbstractControl,
  FormControl,
  FormGroup,
  ValidatorFn,
  Validators,
} from '@angular/forms';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'], // Corrigez cette propriété pour qu'elle soit au pluriel
})
export class RegisterComponent {
  registerForm: FormGroup;
  loading = false;

  constructor() {
    this.registerForm = new FormGroup(
      {
        email: new FormControl('', [Validators.required, Validators.email]),
        birthDate: new FormControl('', [
          Validators.required,
          Validators.pattern(/^\d{4}-\d{2}-\d{2}$/),
        ]),
        firstname: new FormControl('', [Validators.required]),
        lastname: new FormControl('', [Validators.required]),
        address: new FormControl('', [Validators.required]),
        country: new FormControl('', [Validators.required]),
        phone: new FormControl('', [
          Validators.required,
          Validators.pattern(/^\+?\d{10,}$/),
        ]),
        password: new FormControl('', [
          Validators.required,
          Validators.minLength(6),
        ]),
        cpassword: new FormControl('', [Validators.required]),
      },
      { validators: this.passwordMatchValidator }
    );
  }

  onSubmit() {
    if (this.registerForm.valid) {
      console.log('Registration form is valid', this.registerForm.value);
      this.loading = true;
      console.log('Form Value:', this.registerForm.value);
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
      console.error('Registration form is not valid');
    }
  }

  passwordMatchValidator: ValidatorFn = (
    control: AbstractControl
  ): { [key: string]: any } | null => {
    const password = control.get('password');
    const cpassword = control.get('cpassword');
    return password && cpassword && password.value !== cpassword.value
      ? { mismatch: true }
      : null;
  };
}
