import { Adherent } from './adherent';
import { Livre } from './livre';

/**
 * Emprunt model
 * @param {number} id - The id of the emprunt
 * @param {Date} date_emprunt - The date of the emprunt
 * @param {Date} date_retour - The return date of the emprunt
 * @param {Date} created_at - The creation date of the emprunt
 * @param {Date} updated_at - The update date of the emprunt
 * @param {Adherent} adherent - The adherent of the emprunt
 * @param {Livre} livre - The book of the emprunt
 */
export class Emprunt {
  constructor(
    public id: number,
    public date_emprunt: Date,
    public date_retour: Date,
    public created_at: Date,
    public updated_at: Date,
    public adherent: Adherent,
    public livre: Livre
  ) {
    adherent.emprunts.push(this);
    livre.emprunts.push(this);
  }
}
