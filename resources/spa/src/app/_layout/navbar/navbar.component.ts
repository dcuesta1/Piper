import { Component, OnInit } from '@angular/core';
import {Router} from '@angular/router';
import {Location} from '@angular/common';


@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit {

  public route: string;
  public routerPathItems: string[];
  public user;

  constructor(private _location: Location, private _router: Router) {
    _router.events.subscribe(val => {
      if (_location.path() != "") {
        this.route = _location.path();
      }
    });


  }

  ngOnInit(): void {
    this.routerPathItems = this.route.split('/');
    const index: number = this.route.indexOf('');

    if (index > -1) {
      this.routerPathItems.splice(index, 1);
    }

    console.log(this.routerPathItems);
  }

}
