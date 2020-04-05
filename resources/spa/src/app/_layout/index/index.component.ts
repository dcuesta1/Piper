import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-index',
  template: `
      <app-navbar></app-navbar>
      <div class="wrapper">
          <app-sidebar></app-sidebar>
          <div id="main">
              <div class="content-wrapper">
<!--                  <div id="loading">-->
<!--                      <div class="spinner">-->
<!--                          <div class="dot1"></div>-->
<!--                          <div class="dot2"></div>-->
<!--                      </div>-->
<!--                      <div class="text-loading">Loading..</div>-->
<!--                  </div>-->
                  <main class="content">
                      <div class="container-fluid">
                          <router-outlet></router-outlet>
                      </div>
                  </main>
              </div>
          </div>
      </div>
  `
})
export class IndexComponent implements OnInit {

  constructor() { }

  ngOnInit(): void {
  }

}
