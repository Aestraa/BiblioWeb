import { Component, OnInit } from '@angular/core';
import {
  AbstractControl,
  FormControl,
  FormGroup,
  ValidatorFn,
  Validators,
} from '@angular/forms';
import { Adherent } from '../models/adherent';
import { ApiService } from '../services/api.service';
import { AuthService } from '../services/auth.service';

@Component({
  selector: 'app-adherent',
  templateUrl: './adherent.component.html',
  styleUrls: ['./adherent.component.css'],
})
export class AdherentComponent implements OnInit {
  loading = true;
  adresse: string[] | undefined;
  date: string[] | undefined;
  adherent!: Adherent;
  modifForm: FormGroup;
  success = false;

  constructor(private api: ApiService, private auth: AuthService) {
    this.modifForm = new FormGroup(
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
        photo: new FormControl('', [Validators.nullValidator]),
      },
      { validators: this.passwordMatchValidator }
    );
  }

  ngOnInit() {
    this.api.getAdherent({ token: this.auth.token }).subscribe(
      (adherent: Adherent) => {
        this.adherent = adherent;
        this.completeForm();
        this.loading = false;
      },
      (error) => {
        console.error('Error fetching adherent:', error);
        this.loading = false;
      }
    );
  }

  completeForm() {
    this.adresse = this.adherent.utilisateur.adressePostale.split(',');
    this.date = new Date(this.adherent.utilisateur.dateNaiss)
      .toISOString()
      .split('T');
    this.modifForm.get('email')?.setValue(this.adherent.utilisateur.email);
    this.modifForm.get('dateNaiss')?.setValue(this.date[0]);
    this.modifForm.get('prenom')?.setValue(this.adherent.utilisateur.prenom);
    this.modifForm.get('nom')?.setValue(this.adherent.utilisateur.nom);
    this.modifForm.get('adressePostale')?.setValue(this.adresse[0].trim());
    this.modifForm.get('pays')?.setValue(this.adresse[1].trim());
    this.modifForm.get('numTel')?.setValue(this.adherent.utilisateur.numTel);
    this.modifForm.get('photo')?.setValue(this.adherent.utilisateur.photo);
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

  onSubmit() {
    if (this.modifForm.valid) {
      this.loading = true;
      this.api
        .modifierAdherent({ ...this.modifForm.value, token: this.auth.token })
        .subscribe((adherent) => {
          this.adherent = adherent;
          this.loading = false;
          this.success = true;
        });
    } else {
      console.error('Registration form is not valid');
    }
  }
}
