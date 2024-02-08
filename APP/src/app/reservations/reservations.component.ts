import { Component } from '@angular/core';
import { Reservation } from '../models/reservation';
import { ApiService } from '../services/api.service';
import { AuthService } from '../services/auth.service';

@Component({
  selector: 'app-reservation',
  templateUrl: './reservations.component.html',
  styleUrl: './reservations.component.css',
})
export class ReservationsComponent {
  reservations: Reservation[] = [];
  loading = true;

  constructor(private api: ApiService, private auth: AuthService) {
    this.api
      .getReservations({ token: this.auth.token })
      .subscribe((reservations) => {
        this.reservations = reservations;
        this.loading = false;
      });
  }
}
