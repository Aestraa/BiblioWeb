import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup } from '@angular/forms';
import { Auteur } from '../models/auteur';
import { Categorie } from '../models/categorie';
import { Livre } from '../models/livre';
import { ApiService } from '../services/api.service';

@Component({
  selector: 'app-livres',
  templateUrl: './livres.component.html',
  styleUrl: './livres.component.css',
})
export class LivresComponent implements OnInit {
  livreSearchForm: FormGroup;
  loading = false;
  livres: Livre[] = [];
  auteurs: Auteur[] = [];
  categories: Categorie[] = [];
  langues: string[] = [];

  constructor(private api: ApiService) {
    this.livreSearchForm = new FormGroup({
      titre: new FormControl(''),
      categorie: new FormControl(''),
      auteur: new FormControl(''),
      date_sortie: new FormControl(''),
      langue: new FormControl(''),
    });
  }

  ngOnInit(): void {
    this.loading = true;
    this.api.getLivres().subscribe((data: any) => {
      this.livres = data as Livre[];
      this.pushAutheurs();
      this.pushCategories();
      this.pushLangues();
      this.loading = false;
    });
  }

  onSubmit() {
    if (this.livreSearchForm.valid) {
      this.search();
    }
  }

  onChange(event: any) {
    // check if all fields are empty
    let allEmpty = true;
    Object.keys(this.livreSearchForm.controls).forEach((key) => {
      if (this.livreSearchForm.controls[key].value) {
        allEmpty = false;
      }
    });
    if (allEmpty) {
      if (!event.target?.value) {
        this.api.getLivres().subscribe((data: any) => {
          this.livres = data as Livre[];
          this.pushAutheurs();
          this.pushCategories();
          this.pushLangues();
          this.loading = false;
        });
      }
    } else {
      this.search();
    }
  }

  search() {
    this.loading = true;
    this.api
      .searchLivre({ ...this.livreSearchForm.value })
      .subscribe((data: any) => {
        this.livres = data as Livre[];
        this.loading = false;
      });
  }

  pushAutheurs() {
    this.livres.forEach((livre) => {
      livre.auteurs.forEach((auteur) => {
        if (!this.auteurs.includes(auteur)) {
          this.auteurs.push(auteur);
        }
      });
    });
  }

  pushCategories() {
    this.livres.forEach((livre) => {
      livre.categories.forEach((categorie) => {
        if (!this.categories.includes(categorie)) {
          this.categories.push(categorie);
        }
      });
    });
  }

  pushLangues() {
    this.livres.forEach((livre) => {
      if (!this.langues.includes(livre.langue)) {
        this.langues.push(livre.langue);
      }
    });
  }
}
