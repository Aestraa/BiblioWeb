import { Livre } from './livre';

/**
 * Categorie model
 * @param {number} id - The id of the categorie
 * @param {string} nom - The name of the categorie
 * @param {string} description - The description of the categorie
 * @param {Date} created_at - The creation date of the categorie
 * @param {Date} updated_at - The update date of the categorie
 * @param {Livre[]} livres - The books of the categorie
 */
export class Categorie {
  constructor(
    public id: number,
    public nom: string,
    public description: string,
    public created_at: Date,
    public updated_at: Date,
    public livres: Livre[] = []
  ) {}
}
