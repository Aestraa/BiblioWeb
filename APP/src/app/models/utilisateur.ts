import { Adherent } from './adherent';

/**
 * Utilisateur model
 * @param {number} id - The id of the user
 * @param {string} email - The email of the user
 * @param {string} nom - The last name of the user
 * @param {string} prenom - The first name of the user
 * @param {Date} dateNaiss - The birth date of the user
 * @param {string} adressePostale - The postal address of the user
 * @param {string} numTel - The phone number of the user
 * @param {string} photo - The photo of the user
 * @param {string[]} roles - The roles of the user
 * @param {Date} created_at - The creation date of the user
 * @param {Date} updated_at - The update date of the user
 * @param {Adherent} adherent - The adherent of the user
 */
export class Utilisateur {
  constructor(
    public id: number,
    public email: string,
    public nom: string,
    public prenom: string,
    public dateNaiss: Date,
    public adressePostale: string,
    public numTel: string,
    public photo: string,
    public roles: string[],
    public createdAt: Date,
    public updatedAt: Date,
    public adherent: Adherent | null = null
  ) {}
}
