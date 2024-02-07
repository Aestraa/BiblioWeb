import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { HttpClientModule } from '@angular/common/http';
import { ReactiveFormsModule } from '@angular/forms';
import { AccueilComponent } from './accueil/accueil.component';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './authentification/login/login.component';
import { RegisterComponent } from './authentification/register/register.component';
import { HeaderComponent } from './header/header.component';
import { HeadercssService } from './headercss.service';
import { LivreComponent } from './livres/livre/livre.component';
import { LivresComponent } from './livres/livres.component';
import { LoaderComponent } from './loader/loader.component';
import { ShowLivreComponent } from './show-livre/show-livre.component';

@NgModule({
  declarations: [
    AppComponent,
    AccueilComponent,
    HeaderComponent,
    LoginComponent,
    RegisterComponent,
    LivresComponent,
    LivreComponent,
    LoaderComponent,
    ShowLivreComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    HttpClientModule,
  ],
  providers: [HeadercssService],
  bootstrap: [AppComponent],
})
export class AppModule {}
