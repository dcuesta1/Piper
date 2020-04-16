import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {AuthService} from '../../_services/auth.service';
import {AppService} from '../../_services/app.service';
import {Router} from '@angular/router';
import {User} from '../../_models/user.model';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html'
})
export class LoginComponent implements OnInit {
  public form: FormGroup;
  public error: boolean = false;

  constructor(
    private _fb: FormBuilder,
    private _authService: AuthService,
    private _appService: AppService,
    private _router: Router
  ) {
    _appService.getCurrentUser().subscribe( user => {
      if (user) {
        this._router.navigate(['/dashboard']);
      }
    });
  }

  ngOnInit(): void {
    this.form = this._fb.group({
      username: ['', Validators.required],
      password: ['', Validators.required]
    });
  }

  get f() {return this.form.controls; }

  public allow()
  {
    return (!this.f.username.pristine
      && this.f.username.valid
      && !this.f.password.pristine
      && this.f.password.valid );
  }

  public onSubmit(): void {
    if (this.form.valid) {
      const input = this.form.value;
      const refresh = this._appService.getRefreshToken();

      this._authService.authenticate(input.username, input.password, refresh)
        .subscribe( (user) => {
          const currentUser = new User(user);
          this._appService.setCurrentUser(currentUser).subscribe( () => {
            this.error = false;
            this._router.navigate(['/dashboard']);
          })
        }, (err) => {
          this.error = true;
        });
    }
  }
}
