import { Component, Input } from '@angular/core';
import { Livre } from '../../models/livre';

@Component({
  selector: '[app-livre]',
  templateUrl: './livre.component.html',
  styleUrl: './livre.component.css',
})
export class LivreComponent {
  @Input() livre!: Livre;
}
