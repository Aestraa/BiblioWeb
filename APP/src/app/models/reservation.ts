import { Adherent } from './adherent';
import { Livre } from './livre';

/**
 * Reservation model
 * @throws {Error} if adherent has more than 3 reservations
 * @param {number} id - The id of the reservation
 * @param {Date} date_resa - The date of the reservation
 * @param {Date} date_resa_fin - The end date of the reservation
 * @param {Date} created_at - The creation date of the reservation
 * @param {Date} updated_at - The update date of the reservation
 * @param {Livre} livre - The book of the reservation
 * @param {Adherent} adherent - The adherent of the reservation
 */
export class Reservation {
  constructor(
    public id: number,
    public dateResa: Date,
    public dateResaFin: Date,
    public createdAt: Date,
    public updatedAt: Date,
    public livre: Livre,
    public adherent: Adherent
  ) {
    if (adherent.reservations.length >= 3)
      throw new Error('Un adhérent ne peut pas réserver plus de 3 livres');
    adherent.reservations.push(this);
    livre.reservation = this;
  }
}
