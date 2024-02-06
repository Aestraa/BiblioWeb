import { Emprunt } from './emprunt';
import { Reservation } from './reservation';
import { Utilisateur } from './utilisateur';

/**
 * Adherent model
 * @param {Utilisateur} utilisateur - The user of the adherent
 * @param {Date} date_adhesion - The adhesion date of the adherent
 * @param {Emprunt[]} emprunts - The loans of the adherent
 * @param {Reservation[]} reservations - The reservations of the adherent
 */
export class Adherent {
  constructor(
    public utilisateur: Utilisateur,
    public dateAdhesion: Date,
    public emprunts: Emprunt[] = [],
    public reservations: Reservation[] = []
  ) {}
}
