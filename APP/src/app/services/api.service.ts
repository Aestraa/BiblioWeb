import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Livre } from '../models/livre';
import { Reservation } from '../models/reservation';
import { Utilisateur } from '../models/utilisateur';

/**
 * Service to communicate with the API
 */
@Injectable({
  providedIn: 'root',
})
export class ApiService {
  // port of the API
  private PORT = 8008;

  // base url of the API
  private baseUrl = `http://localhost:${this.PORT}/api`;

  /**
   * Constructor
   * @param http Injected HttpClient
   */
  constructor(private http: HttpClient) {}

  /**
   * Get livres from the API
   * @returns Observable<Livre[]> Livres
   */
  public getLivres(): Observable<Livre[]> {
    return this.http.get<Livre[]>(`${this.baseUrl}/livres`);
  }

  /**
   * Get livre by name, author or category
   * @param search String to search
   * @returns Observable<Livre[]> Livres
   */
  public searchLivre(search: string): Observable<Livre[]> {
    return this.http.get<Livre[]>(`${this.baseUrl}/livre/search/${search}`);
  }

  public getLivre(id: number): Observable<Livre> {
    return this.http.get<Livre>(`${this.baseUrl}/livre/${id}`);
  }

  /**
   * Login to the API
   * @param email the email of the user
   * @param password the password of the user
   * @returns Observable<Utilisateur> the user
   */
  public login({
    email,
    password,
  }: {
    email: string;
    password: string;
  }): Observable<{ token: string }> {
    return this.http.post<{ token: string }>(`${this.baseUrl}/login`, {
      email,
      password,
    });
  }

  /**
   * Create a new user
   * @param email the email of the user
   * @param password the password of the user
   * @param birthDate the birth date of the user
   * @param firstname the first name of the user
   * @param lastname the last name of the user
   * @param address the address of the user
   * @param country the country of the user
   * @param phone the phone number of the user
   * @returns Observable<Utilisateur> the user
   */
  public register({
    email,
    password,
    dateNaiss,
    prenom,
    nom,
    adressePostale,
    pays,
    numTel,
  }: {
    id: number;
    email: string;
    password: string;
    dateNaiss: string;
    prenom: string;
    nom: string;
    adressePostale: string;
    pays: string;
    numTel: string;
  }): Observable<Utilisateur> {
    adressePostale = adressePostale + ', ' + pays;
    dateNaiss = new Date(dateNaiss).toISOString();
    return this.http.post<Utilisateur>(`${this.baseUrl}/adherent`, {
      email,
      password,
      dateNaiss,
      prenom,
      nom,
      adressePostale,
      numTel,
    });
  }

  // TODO: TO MODIFY WITH ADHERENT CLASS
  /**
   * Get the user by id
   * @param id the id of the user
   * @param token the token of the user
   * @returns Observable<Utilisateur> the user
   */
  public getAdherent({
    id,
    token,
  }: {
    id: number;
    token: string;
  }): Observable<Utilisateur> {
    // add the token in the header
    const headers = new HttpHeaders().set('Authorization', `Bearer ${token}`);
    // return the user
    return this.http.get<Utilisateur>(`${this.baseUrl}/adherent/${id}`, {
      headers,
    });
  }

  // TODO: TO MODIFY WITH ADHERENT CLASS
  /**
   * Get the reservations of the user
   * @param id the id of the user
   * @param email the email of the user
   * @param password the password of the user
   * @param birthDate the birth date of the user
   * @param firstname the first name of the user
   * @param lastname the last name of the user
   * @param address the address of the user
   * @param country the country of the user
   * @param phone the phone number of the user
   * @param token the token of the user
   * @returns Observable<Utilisateur> the user
   */
  public putAdherent({
    id,
    email,
    password,
    dateNaiss,
    prenom,
    nom,
    adressePostale,
    pays,
    numTel,
    token,
  }: {
    id: number;
    email: string;
    password: string;
    dateNaiss: string;
    prenom: string;
    nom: string;
    adressePostale: string;
    pays: string;
    numTel: string;
    token: string;
  }): Observable<Utilisateur> {
    adressePostale = adressePostale + ', ' + pays;
    dateNaiss = new Date(dateNaiss).toISOString();
    const headers = new HttpHeaders().set('Authorization', `Bearer ${token}`);
    return this.http.put<Utilisateur>(
      `${this.baseUrl}/adherents/${id}`,
      {
        email,
        password,
        dateNaiss,
        prenom,
        nom,
        adressePostale,
        numTel,
      },
      { headers }
    );
  }

  // TODO: ADAPT WITH API
  /**
   * Get the reservations of the user
   * @param livre the id of the book
   * @param token the token of the user
   * @returns Observable<Reservation> the reservation
   */
  public postReservation({
    livre,
    token,
  }: {
    livre: number;
    token: string;
  }): Observable<Reservation> {
    const headers = new HttpHeaders().set('Authorization', `Bearer ${token}`);
    return this.http.post<Reservation>(
      `${this.baseUrl}/reservations`,
      {
        livre,
        token,
      },
      { headers }
    );
  }

  /**
   * Get the reservations of the user
   * @param id the id of the user
   * @param token the token of the user
   * @returns Observable<Reservation[]> the reservations
   */
  public getReservations({
    token,
  }: {
    token: string;
  }): Observable<Reservation[]> {
    const headers = new HttpHeaders().set('Authorization', `Bearer ${token}`);
    return this.http.get<Reservation[]>(`${this.baseUrl}/reservations`, {
      headers,
    });
  }

  // TODO: ADAPT WITH API
  /**
   * Get the reservations of the user
   * @param id the id of the reservation
   * @param date_resa the date of the reservation
   * @param date_resa_fin the end date of the reservation
   * @param livre the book of the reservation
   * @param adherent the user of the reservation
   * @param token the token of the user
   * @returns Observable<Reservation> the reservationbearer:
   */
  public putReservation({
    id,
    date_resa,
    date_resa_fin,
    livre,
    adherent,
    token,
  }: {
    id: number;
    date_resa: Date;
    date_resa_fin: Date;
    livre: Livre;
    adherent: Utilisateur;
    token: string;
  }): Observable<Reservation> {
    const headers = new HttpHeaders().set('Authorization', `Bearer ${token}`);
    return this.http.put<Reservation>(
      `${this.baseUrl}/reservations/${id}`,
      {
        date_resa,
        date_resa_fin,
        livre,
        adherent,
      },
      { headers }
    );
  }

  /**
   * Get the reservations of the user
   * @param id the id of the reservation
   * @param token the token of the user
   * @returns Observable<Reservation> the reservation
   */
  public deleteReservation({
    id,
    token,
  }: {
    id: number;
    token: string;
  }): Observable<Reservation> {
    const headers = new HttpHeaders().set('Authorization', `Bearer ${token}`);
    return this.http.delete<Reservation>(`${this.baseUrl}/reservations/${id}`, {
      headers,
    });
  }
}
