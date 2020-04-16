import { Injectable } from '@angular/core';
import {InitialLogUserData} from '../_models/initial.log.user.data';
import * as data from './dataMocks/admin.user.mock.json';
import {AppService} from './app.service';
import {HttpClient} from '@angular/common/http';
import {User} from '../_models/user.model';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private _initialLogUserData: InitialLogUserData;
  private _device: string;

  constructor(
    private _http: HttpClient,
    private _appService: AppService,
  ) {}

  authenticate(username: string, password: string, refresh?: string) {
    return this._http.post<User>('/authenticate', { username, password, refresh});
  }

  register(user: User) {
    return this._http.post<User>('/register', {user});
  }

  sendEmailRecover(email: string) {
    return this._http.post('/passwordRecover',  {email});
  }

  confirmCodeRecover(code: number) {
    return this._http.post('/checkRecoverCode', {code});
  }

  destroy() {
    const token = this._appService.getAuthToken();
    return this._http.post('/signout', {token})
  }
}
