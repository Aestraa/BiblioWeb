import { Component } from '@angular/core';
import { Adherent } from '../models/adherent';
import { ApiService } from '../services/api.service';
import { Utilisateur } from '../models/utilisateur';
import { FormControl, FormGroup, Validators, ValidatorFn, AbstractControl } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../services/auth.service';

const Util = new Utilisateur(11,"test@test.com", "test", "test", new Date("1992-11-02"),"test,France","0612345678","test",["ROLE_ADHERENT","ROLE_USER"],new Date("01/01/1990"),new Date("01/01/1990"), null);

@Component({
  selector: 'app-adherent',
  templateUrl: './adherent.component.html',
  styleUrl: './adherent.component.css'
})
export class AdherentComponent {
  loading = false;
  adresse: string[] | undefined
  date: string[] | undefined
  adherent = new Adherent(11,Util, new Date("01/01/1990"), [],[]);
  registerForm: FormGroup;


  constructor(private api: ApiService, private router: Router, private auth: AuthService) {
    this.adresse = this.adherent.utilisateur.adressePostale.split(",");
    this.date = this.adherent.utilisateur.dateNaiss.toISOString().split("T");
    this.registerForm = new FormGroup(
      {
        email: new FormControl(this.adherent.utilisateur.email, [Validators.required, Validators.email]),
        dateNaiss: new FormControl(this.date[0], [
          Validators.required,
          Validators.pattern(/^\d{4}-\d{2}-\d{2}$/),
        ]),
        prenom: new FormControl(this.adherent.utilisateur.prenom, [Validators.required]),
        nom: new FormControl(this.adherent.utilisateur.nom, [Validators.required]),
        adressePostale: new FormControl(this.adresse[0], [Validators.required]),
        pays: new FormControl(this.adresse[1], [Validators.required]),
        numTel: new FormControl(this.adherent.utilisateur.numTel, [
          Validators.required,
          Validators.pattern(/^\+?\d{10,}$/),
        ]),
        img: new FormControl('', [Validators.nullValidator]),
      },
      { validators: this.passwordMatchValidator }
    );
  }

  passwordMatchValidator: ValidatorFn | undefined

  onSubmit() {
    if (this.registerForm.valid) {
      console.log('Registration form is valid', this.registerForm.value);
      /*this.loading = true;
      this.api.register({ ...this.registerForm.value }).subscribe(() => {
        this.loading = false;*/
        this.redirectTo('/adherent/'+this.adherent.id);
      //});
    } else {
      console.error('Registration form is not valid');
    }
  }

  redirectTo(uri: string) {
    this.router.navigateByUrl('/', { skipLocationChange: true }).then(() => {
      this.router.navigate([uri])});
  }

  ngOnInit(): void {
    /*this.loading = true;
    this.api.getAdherent({id:this.adherent.id, token: this.auth.token }).subscribe((data: any) => {
      this.adherent = data as Adherent;
      this.loading = false;
    });*/

  }
}
