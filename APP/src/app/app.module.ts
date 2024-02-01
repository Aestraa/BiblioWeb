import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { AccueilComponent } from './accueil/accueil.component';
import { HeaderComponent } from './header/header.component';
import { HeadercssService } from './headercss.service';

@NgModule({
  declarations: [
    AppComponent,
    AccueilComponent,
    HeaderComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule
  ],
  providers: [HeadercssService],
  bootstrap: [AppComponent]
})
export class AppModule { }
