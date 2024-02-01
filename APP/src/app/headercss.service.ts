import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class HeadercssService {
  private headerOffset = new BehaviorSubject<number>(0);
  headerOffset$ = this.headerOffset.asObservable();

  setOffset(offset: number) {
    this.headerOffset.next(offset);
  }

  constructor() { }
}
