import { Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Livre } from '../models/livre';
import { ApiService } from '../services/api.service';

@Component({
  selector: 'app-show-livre',
  templateUrl: './show-livre.component.html',
  styleUrl: './show-livre.component.css',
})
export class ShowLivreComponent {
  livre: Livre | null = null;
  loading = false;

  constructor(
    private activatedRoute: ActivatedRoute,
    private router: Router,
    private api: ApiService
  ) {
    this.loading = true;
    let idParam = this.activatedRoute.snapshot.paramMap.get('id');
    let id = idParam !== null ? +idParam : null; // Convert to number if not null

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
}
