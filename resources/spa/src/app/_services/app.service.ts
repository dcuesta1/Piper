import { environment } from '../../environments/environment';
import {EventEmitter, Injectable, Output} from '@angular/core';
import { Observable } from 'rxjs';
import { LocalStorage } from '../_etc/LocalStorage';
import {User} from '../_models/user.model';


@Injectable({
  providedIn: 'root'
})
export class AppService {
  private static readonly AUTH_EXPIRY = 1209600000; // 15 days

  public static readonly CURRENT_USER_LOCAL_KEY = 'user';
  public static readonly IMPERSONATE_LOCAL_KEY = 'im';

  public loggedIn: boolean;
  private _isLoading = true;

  private results: any;

  @Output() loader: EventEmitter<boolean> = new EventEmitter();

  public constructor(private _localStorage: LocalStorage) {}

  public getLocationPath() {
    return window.location.pathname.substr(1).split('/');
  }

  public getImpersonatedUser(): User {
    return JSON.parse(localStorage.getItem(environment.const.impersonate));
  }

  public removeImpersonatedUser(): void {
    this._localStorage.removeItem(environment.const.impersonate);
  }

  public setImpersonatedUser(user: User): void {
    localStorage.setItem(environment.const.impersonate, JSON.stringify(user));
  }

  public getCurrentUser(): Observable<User> {
    return this._localStorage.getItem(AppService.CURRENT_USER_LOCAL_KEY);
  }

  public setCurrentUser(user: User) {
    return this._localStorage.setItem(AppService.CURRENT_USER_LOCAL_KEY, user, AppService.AUTH_EXPIRY);
  }

  public removeCurrentUser(): void {
    this._localStorage.removeItem(environment.const.currentUser);
  }

  public getRefreshToken(): string | null {
    this.results = null;

    this._localStorage.getItem(environment.const.refresh).subscribe(token => {
      this.results = token;
    });

    return this.results;
  }

  public setRefreshToken(token: string): void {
    const year: number = 29030400000;
    this._localStorage.setItem(environment.const.refresh, token, year);
  }

  public removeRefreshToken(): void {
    this._localStorage.removeItem(environment.const.refresh);
  }

  public getAuthToken(): string | null {
    return localStorage.getItem(environment.const.authToken);
  }

  public setAuthToken(token: string): void {
    this._localStorage.setItem(environment.const.authToken, token, AppService.AUTH_EXPIRY)
  }

  public removeAuthToken(): void {
    this._localStorage.removeItem(environment.const.authToken);
  }

  public clear(): void {
    this.removeCurrentUser();
    this.removeAuthToken();
    this.removeImpersonatedUser();
  }

  get isloading() {
    return this._isLoading;
  }

  toggleLoading(val: boolean) {
    this._isLoading = val;
    this.loader.emit(this._isLoading);
  }
}
