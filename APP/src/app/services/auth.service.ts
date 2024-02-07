import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  constructor() {}

  get token(): string {
    return localStorage.getItem('token') ?? '';
  }

  set token(token: string) {
    localStorage.setItem('token', token);
  }

  get isLogged(): boolean {
    return this.token !== '';
  }

  logout(): void {
    localStorage.removeItem('token');
  }
}
