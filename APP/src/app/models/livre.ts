import { Auteur } from './auteur';
import { Categorie } from './categorie';
import { Emprunt } from './emprunt';
import { Reservation } from './reservation';

/**
 * Livre model
 * @param {number} id - The id of the book
 * @param {string} titre - The title of the book
 * @param {Date} date_sortie - The release date of the book
 * @param {string} langue - The language of the book
 * @param {string} photo_couverture - The cover photo of the book
 * @param {Date} created_at - The creation date of the book
 * @param {Date} updated_at - The update date of the book
 * @param {Emprunt[]} emprunts - The loans of the book
 * @param {Auteur[]} auteurs - The authors of the book
 * @param {Categorie[]} categories - The categories of the book
 * @param {Reservation} reservation - The reservation of the book
 */
export class Livre {
  constructor(
    public id: number,
    public titre: string,
    public dateSortie: Date,
    public langue: string,
    public photoCouverture: string,
    public createdAt: Date,
    public updatedAt: Date,
    public emprunts: Emprunt[] = [],
    public auteurs: Auteur[] = [],
    public categories: Categorie[] = [],
    public reservations: Reservation | null = null
  ) {}
}
