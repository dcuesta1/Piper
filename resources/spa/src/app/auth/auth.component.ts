import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-auth',
  template: `
    <div class="authWrapper">
      <div class="authContainer">
          <div class="logo">Piper Dashboard</div>
          <router-outlet></router-outlet>
      </div>
    </div>    
  `
})
export class AuthComponent implements OnInit { ngOnInit() {} }
