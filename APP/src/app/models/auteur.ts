import { Livre } from './livre';

/**
 * Auteur model
 * @param {number} id - The id of the author
 * @param {string} nom - The name of the author
 * @param {string} prenom - The first name of the author
 * @param {Date} date_naissance - The birth date of the author
 * @param {Date} date_deces - The death date of the author
 * @param {string} nationalite - The nationality of the author
 * @param {string} photo - The photo of the author
 * @param {string} description - The description of the author
 * @param {Date} created_at - The creation date of the author
 * @param {Date} updated_at - The update date of the author
 * @param {Livre[]} livres - The books of the author
 */
export class Auteur {
  constructor(
    public id: number,
    public nom: string,
    public prenom: string,
    public dateNaissance: Date,
    public dateDeces: Date,
    public nationalite: string,
    public photo: string,
    public description: string,
    public createdAt: Date,
    public updatedAt: Date,
    public livres: Livre[] = []
  ) {}
}
