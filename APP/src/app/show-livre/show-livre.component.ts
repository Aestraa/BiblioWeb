import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { Livre } from '../models/livre';
import { ApiService } from '../services/api.service';
import { AuthService } from '../services/auth.service';

@Component({
  selector: 'app-show-livre',
  templateUrl: './show-livre.component.html',
  styleUrl: './show-livre.component.css',
})
export class ShowLivreComponent {
  livre: Livre | null = null;
  loading = false;
  reservationForm: FormGroup;

  constructor(
    private activatedRoute: ActivatedRoute,
    private router: Router,
    private api: ApiService,
    public auth: AuthService
  ) {
    this.loading = true;
    let idParam = this.activatedRoute.snapshot.paramMap.get('id');
    let id = idParam !== null ? +idParam : null; // Convert to number if not null
    this.reservationForm = new FormGroup({
      id: new FormControl(id, Validators.required),
    });

    // Check if id is a number and not NaN
    if (id === null || isNaN(id)) {
      this.router.navigate(['/livres']);
    } else {
      this.api.getLivre(id).subscribe(
        (data) => {
          this.livre = data;
          this.loading = false;
        },
        () => {
          this.livre = null;
          this.loading = false;
        }
      );
    }
  }

  onSubmit() {
    this.loading = true;
    if (this.reservationForm.valid) {
      this.api
        .postReservation({
          Livre: this.reservationForm.value.id,
          token: this.auth.token,
        })
        .subscribe(() => {
          this.router.navigate(['/reservations']);
        });
    }
  }
}
