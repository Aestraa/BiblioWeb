import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AccueilComponent } from './accueil/accueil.component';
import { LoginComponent } from './authentification/login/login.component';
import { RegisterComponent } from './authentification/register/register.component';
import { LivresComponent } from './livres/livres.component';
import { ReservationsComponent } from './reservations/reservations.component';
import { ShowLivreComponent } from './show-livre/show-livre.component';
import { AdherentComponent } from './adherent/adherent.component';

const routes: Routes = [
  { path: '', component: AccueilComponent },
  { path: 'auth/login', component: LoginComponent },
  { path: 'auth/register', component: RegisterComponent },
  { path: 'livres', component: LivresComponent },
  { path: 'livre/:id', component: ShowLivreComponent },
  { path: 'adherent/:id', component: AdherentComponent },
  { path: 'reservations', component: ReservationsComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
})
export class AppRoutingModule {}
