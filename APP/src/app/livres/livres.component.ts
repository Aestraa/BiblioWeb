import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Auteur } from '../models/auteur';
import { Categorie } from '../models/categorie';
import { Livre } from '../models/livre';

@Component({
  selector: 'app-livres',
  templateUrl: './livres.component.html',
  styleUrl: './livres.component.css',
})
export class LivresComponent {
  searchForm = new FormGroup({
    search: new FormControl('', Validators.required),
  });
  loading = false;
  livres: Livre[] = [
    new Livre(
      1,
      'Fareinheit 451',
      new Date('1953-10-19'),
      'FR',
      'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bf/FAHRENHEIT_451_by_Ray_Bradbury%2C_Corgi_1957._160_pages._Cover_by_John_Richards.jpg/800px-FAHRENHEIT_451_by_Ray_Bradbury%2C_Corgi_1957._160_pages._Cover_by_John_Richards.jpg',
      new Date('2021-10-19'),
      new Date('2021-10-19'),
      [],
      [
        new Auteur(
          1,
          'Ray',
          'Bradbury',
          new Date('1920-08-22'),
          new Date('2012-06-05'),
          'American',
          'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Ray_Bradbury_1975.jpg/800px-Ray_Bradbury_1975.jpg',
          'An American author and screenwriter. One of the most celebrated 20th- and 21st-century American writers, he worked in a variety of genres including fantasy, science fiction, horror, and mystery fiction.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
        new Auteur(
          1,
          'Ray',
          'Bradbury',
          new Date('1920-08-22'),
          new Date('2012-06-05'),
          'American',
          'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Ray_Bradbury_1975.jpg/800px-Ray_Bradbury_1975.jpg',
          'An American author and screenwriter. One of the most celebrated 20th- and 21st-century American writers, he worked in a variety of genres including fantasy, science fiction, horror, and mystery fiction.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
      ],
      [
        new Categorie(
          1,
          'Science Fiction',
          'A story that deals with technology and the future.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
        new Categorie(
          1,
          'Science Fiction',
          'A story that deals with technology and the future.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
      ]
    ),
    new Livre(
      1,
      'Fareinheit 451',
      new Date('1953-10-19'),
      'FR',
      'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bf/FAHRENHEIT_451_by_Ray_Bradbury%2C_Corgi_1957._160_pages._Cover_by_John_Richards.jpg/800px-FAHRENHEIT_451_by_Ray_Bradbury%2C_Corgi_1957._160_pages._Cover_by_John_Richards.jpg',
      new Date('2021-10-19'),
      new Date('2021-10-19'),
      [],
      [
        new Auteur(
          1,
          'Ray',
          'Bradbury',
          new Date('1920-08-22'),
          new Date('2012-06-05'),
          'American',
          'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Ray_Bradbury_1975.jpg/800px-Ray_Bradbury_1975.jpg',
          'An American author and screenwriter. One of the most celebrated 20th- and 21st-century American writers, he worked in a variety of genres including fantasy, science fiction, horror, and mystery fiction.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
        new Auteur(
          1,
          'Ray',
          'Bradbury',
          new Date('1920-08-22'),
          new Date('2012-06-05'),
          'American',
          'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Ray_Bradbury_1975.jpg/800px-Ray_Bradbury_1975.jpg',
          'An American author and screenwriter. One of the most celebrated 20th- and 21st-century American writers, he worked in a variety of genres including fantasy, science fiction, horror, and mystery fiction.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
      ],
      [
        new Categorie(
          1,
          'Science Fiction',
          'A story that deals with technology and the future.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
        new Categorie(
          1,
          'Science Fiction',
          'A story that deals with technology and the future.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
      ]
    ),
    new Livre(
      1,
      'Fareinheit 451',
      new Date('1953-10-19'),
      'FR',
      'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bf/FAHRENHEIT_451_by_Ray_Bradbury%2C_Corgi_1957._160_pages._Cover_by_John_Richards.jpg/800px-FAHRENHEIT_451_by_Ray_Bradbury%2C_Corgi_1957._160_pages._Cover_by_John_Richards.jpg',
      new Date('2021-10-19'),
      new Date('2021-10-19'),
      [],
      [
        new Auteur(
          1,
          'Ray',
          'Bradbury',
          new Date('1920-08-22'),
          new Date('2012-06-05'),
          'American',
          'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Ray_Bradbury_1975.jpg/800px-Ray_Bradbury_1975.jpg',
          'An American author and screenwriter. One of the most celebrated 20th- and 21st-century American writers, he worked in a variety of genres including fantasy, science fiction, horror, and mystery fiction.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
        new Auteur(
          1,
          'Ray',
          'Bradbury',
          new Date('1920-08-22'),
          new Date('2012-06-05'),
          'American',
          'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Ray_Bradbury_1975.jpg/800px-Ray_Bradbury_1975.jpg',
          'An American author and screenwriter. One of the most celebrated 20th- and 21st-century American writers, he worked in a variety of genres including fantasy, science fiction, horror, and mystery fiction.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
      ],
      [
        new Categorie(
          1,
          'Science Fiction',
          'A story that deals with technology and the future.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
        new Categorie(
          1,
          'Science Fiction',
          'A story that deals with technology and the future.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
      ]
    ),
    new Livre(
      1,
      'Fareinheit 451',
      new Date('1953-10-19'),
      'FR',
      'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bf/FAHRENHEIT_451_by_Ray_Bradbury%2C_Corgi_1957._160_pages._Cover_by_John_Richards.jpg/800px-FAHRENHEIT_451_by_Ray_Bradbury%2C_Corgi_1957._160_pages._Cover_by_John_Richards.jpg',
      new Date('2021-10-19'),
      new Date('2021-10-19'),
      [],
      [
        new Auteur(
          1,
          'Ray',
          'Bradbury',
          new Date('1920-08-22'),
          new Date('2012-06-05'),
          'American',
          'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Ray_Bradbury_1975.jpg/800px-Ray_Bradbury_1975.jpg',
          'An American author and screenwriter. One of the most celebrated 20th- and 21st-century American writers, he worked in a variety of genres including fantasy, science fiction, horror, and mystery fiction.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
        new Auteur(
          1,
          'Ray',
          'Bradbury',
          new Date('1920-08-22'),
          new Date('2012-06-05'),
          'American',
          'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Ray_Bradbury_1975.jpg/800px-Ray_Bradbury_1975.jpg',
          'An American author and screenwriter. One of the most celebrated 20th- and 21st-century American writers, he worked in a variety of genres including fantasy, science fiction, horror, and mystery fiction.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
      ],
      [
        new Categorie(
          1,
          'Science Fiction',
          'A story that deals with technology and the future.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
        new Categorie(
          1,
          'Science Fiction',
          'A story that deals with technology and the future.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
      ]
    ),
    new Livre(
      1,
      'Fareinheit 451',
      new Date('1953-10-19'),
      'FR',
      'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bf/FAHRENHEIT_451_by_Ray_Bradbury%2C_Corgi_1957._160_pages._Cover_by_John_Richards.jpg/800px-FAHRENHEIT_451_by_Ray_Bradbury%2C_Corgi_1957._160_pages._Cover_by_John_Richards.jpg',
      new Date('2021-10-19'),
      new Date('2021-10-19'),
      [],
      [
        new Auteur(
          1,
          'Ray',
          'Bradbury',
          new Date('1920-08-22'),
          new Date('2012-06-05'),
          'American',
          'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Ray_Bradbury_1975.jpg/800px-Ray_Bradbury_1975.jpg',
          'An American author and screenwriter. One of the most celebrated 20th- and 21st-century American writers, he worked in a variety of genres including fantasy, science fiction, horror, and mystery fiction.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
        new Auteur(
          1,
          'Ray',
          'Bradbury',
          new Date('1920-08-22'),
          new Date('2012-06-05'),
          'American',
          'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Ray_Bradbury_1975.jpg/800px-Ray_Bradbury_1975.jpg',
          'An American author and screenwriter. One of the most celebrated 20th- and 21st-century American writers, he worked in a variety of genres including fantasy, science fiction, horror, and mystery fiction.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
      ],
      [
        new Categorie(
          1,
          'Science Fiction',
          'A story that deals with technology and the future.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
        new Categorie(
          1,
          'Science Fiction',
          'A story that deals with technology and the future.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
      ]
    ),
    new Livre(
      1,
      'Fareinheit 451',
      new Date('1953-10-19'),
      'FR',
      'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bf/FAHRENHEIT_451_by_Ray_Bradbury%2C_Corgi_1957._160_pages._Cover_by_John_Richards.jpg/800px-FAHRENHEIT_451_by_Ray_Bradbury%2C_Corgi_1957._160_pages._Cover_by_John_Richards.jpg',
      new Date('2021-10-19'),
      new Date('2021-10-19'),
      [],
      [
        new Auteur(
          1,
          'Ray',
          'Bradbury',
          new Date('1920-08-22'),
          new Date('2012-06-05'),
          'American',
          'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Ray_Bradbury_1975.jpg/800px-Ray_Bradbury_1975.jpg',
          'An American author and screenwriter. One of the most celebrated 20th- and 21st-century American writers, he worked in a variety of genres including fantasy, science fiction, horror, and mystery fiction.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
        new Auteur(
          1,
          'Ray',
          'Bradbury',
          new Date('1920-08-22'),
          new Date('2012-06-05'),
          'American',
          'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Ray_Bradbury_1975.jpg/800px-Ray_Bradbury_1975.jpg',
          'An American author and screenwriter. One of the most celebrated 20th- and 21st-century American writers, he worked in a variety of genres including fantasy, science fiction, horror, and mystery fiction.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
      ],
      [
        new Categorie(
          1,
          'Science Fiction',
          'A story that deals with technology and the future.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
        new Categorie(
          1,
          'Science Fiction',
          'A story that deals with technology and the future.',
          new Date('2021-10-19'),
          new Date('2021-10-19')
        ),
      ]
    ),
  ];

  onSubmit() {
    if (this.searchForm.valid) {
      this.loading = true;
      console.log('Form Value:', this.searchForm.value);
      this.loading = false;
    } else {
      console.error('Form is not valid');
    }
  }
}
