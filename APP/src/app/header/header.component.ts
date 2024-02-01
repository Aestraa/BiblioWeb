import { Component, HostListener } from '@angular/core';
import { HeadercssService } from '../headercss.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrl: './header.component.css'
})
export class HeaderComponent {
  isSticky: boolean = false;
  bandeau:any = "assets/images/bandeau.jpg";

  constructor(private headercssService: HeadercssService) {}

  onScroll(event: Event) {
    const isSmallScreen = window.innerWidth < 768; // Adjust the threshold based on your needs
  const scrollOffset = window.scrollY;

  // If it's a small screen, adjust the scrollOffset
  const adjustedScrollOffset = isSmallScreen ? scrollOffset + 250 : scrollOffset;

  this.isSticky = adjustedScrollOffset >= 410;
  }

}
