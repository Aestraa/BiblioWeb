import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Livre } from '../models/livre';
import { ApiService } from '../services/api.service';

@Component({
  selector: 'app-livres',
  templateUrl: './livres.component.html',
  styleUrl: './livres.component.css',
})
export class LivresComponent implements OnInit {
  searchForm = new FormGroup({
    search: new FormControl('', Validators.required),
  });
  loading = false;
  livres: Livre[] = [];

  constructor(private api: ApiService) {}

  ngOnInit(): void {
    this.loading = true;
    this.api.getLivres().subscribe((data: any) => {
      this.livres = data as Livre[];
      this.loading = false;
    });
  }

  onSubmit() {
    if (this.searchForm.valid) {
      this.loading = true;
      this.api
        .searchLivre(this.searchForm.value.search as string)
        .subscribe((data: any) => {
          this.livres = data as Livre[];
          this.loading = false;
        });
    }
  }

  onChange(event: any) {
    if (!event.target?.value) {
      this.loading = true;
      this.api.getLivres().subscribe((data: any) => {
        this.livres = data as Livre[];
        this.loading = false;
      });
    }
  }
}
