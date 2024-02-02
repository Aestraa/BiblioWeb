import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AccueilComponent } from './accueil/accueil.component';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { FormControlComponent } from './authentification/form-control/form-control.component';
import { LoginComponent } from './authentification/login/login.component';
import { RegisterComponent } from './authentification/register/register.component';
import { HeaderComponent } from './header/header.component';
import { HeadercssService } from './headercss.service';

@NgModule({
  declarations: [
    AppComponent,
    AccueilComponent,
    HeaderComponent,
    LoginComponent,
    RegisterComponent,
    FormControlComponent,
  ],
  imports: [BrowserModule, AppRoutingModule],
  providers: [HeadercssService],
  bootstrap: [AppComponent],
})
export class AppModule {}
