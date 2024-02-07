import { Component } from '@angular/core';
import {
  AbstractControl,
  FormControl,
  FormGroup,
  ValidatorFn,
  Validators,
} from '@angular/forms';
import { Router } from '@angular/router';
import { ApiService } from '../../services/api.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'], // Corrigez cette propriété pour qu'elle soit au pluriel
})
export class RegisterComponent {
  registerForm: FormGroup;
  loading = false;

  constructor(private api: ApiService, private router: Router) {
    this.registerForm = new FormGroup(
      {
        email: new FormControl('', [Validators.required, Validators.email]),
        dateNaiss: new FormControl('', [
          Validators.required,
          Validators.pattern(/^\d{4}-\d{2}-\d{2}$/),
        ]),
        prenom: new FormControl('', [Validators.required]),
        nom: new FormControl('', [Validators.required]),
        adressePostale: new FormControl('', [Validators.required]),
        pays: new FormControl('', [Validators.required]),
        numTel: new FormControl('', [
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
      this.api.register({ ...this.registerForm.value }).subscribe(() => {
        this.loading = false;
        this.router.navigate(['/auth/login']);
      });
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
