import { Component, Input } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Reservation } from '../../models/reservation';
import { ApiService } from '../../services/api.service';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-reservation',
  templateUrl: './reservation.component.html',
  styleUrl: './reservation.component.css',
})
export class ReservationComponent {
  @Input() reservation!: Reservation;
  reservationForm: FormGroup;
  suppression = false;

  constructor(private api: ApiService, private auth: AuthService) {
    this.reservationForm = new FormGroup({
      id: new FormControl('', Validators.required),
    });
  }

  onSubmit() {
    let confirmation = confirm(
      'Voulez-vous vraiment supprimer cette réservation ?'
    );
    if (confirmation) {
      this.api
        .deleteReservation({
          ...this.reservationForm.value,
          token: this.auth.token,
        })
        .subscribe(() => {
          this.suppression = true;
        });
    }
  }
}
