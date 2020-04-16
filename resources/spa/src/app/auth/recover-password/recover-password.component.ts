import { Component, OnInit } from '@angular/core';
import {AuthService} from '../../_services/auth.service';

@Component({
  selector: 'app-recover-password',
  templateUrl: './recover-password.component.html'
})
export class RecoverPasswordComponent implements OnInit {
  public step = 1;
  public email;
  public code;
  public password;

  constructor(
    private _authService: AuthService
  ) { }

  ngOnInit(): void {
  }

  public submitEmail() {
    // this._authService.sendEmailRecover()
    this.step = 2;
    console.log(this.email);
  }

  public submitCode() {
    this.step = 3;
    console.log(this.code);
  }
  public submitPassword() {
    console.log(this.password)
  }

  public alreadyHaveCode() {
    this.step = 2;
  }
}
