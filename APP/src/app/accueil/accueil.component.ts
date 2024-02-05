import { Component } from '@angular/core';
import { Router } from '@angular/router';

declare const currentSlide: any;

@Component({
  selector: 'app-accueil',
  templateUrl: './accueil.component.html',
  styleUrl: './accueil.component.css'
})
export class AccueilComponent {
  constructor(public rt: Router){}

   pourcent:number[] = generateRandomNumbers(5);

  event1:any = "assets/Images/scroll.jpg";
  event2:any = "assets/Images/scroll.jpg";
  event3:any = "assets/Images/scroll.jpg";
  event4:any = "assets/Images/scroll.jpg";
  vedette:any = "assets/Images/west.jpg";

  ngOnInit() {
    currentSlide(1)
  }

  getLeftPosition(index: number): number {
    return 23 + index * 18; 
  }

}

function generateRandomNumbers(length: number): number[] {
  const randomNumbers: number[] = [];

  for (let i = 0; i < length; i++) {
    let randomNumber = Math.floor(Math.random() * (50 - 5 + 1)) + 5;
    randomNumber = Math.floor(randomNumber / 5) * 5;
    randomNumbers.push(randomNumber);
  }

  return randomNumbers;
}


