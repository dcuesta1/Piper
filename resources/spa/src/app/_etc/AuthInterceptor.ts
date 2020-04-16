import {Injectable} from '@angular/core';
import {
  HTTP_INTERCEPTORS,
  HttpErrorResponse,
  HttpEvent,
  HttpHandler,
  HttpInterceptor,
  HttpRequest,
  HttpResponse
} from '@angular/common/http';
import {AppService} from '../_services/app.service';
import {Router} from '@angular/router';
import {Observable, throwError} from 'rxjs';
import { environment  } from '../../environments/environment';
import {switchMap, tap} from 'rxjs/operators';
import {SnakeToCamel} from './SnakeToCamel';

@Injectable()
export class AuthInterceptor implements HttpInterceptor {
  constructor(
    private _appService: AppService,
    private _router: Router
  ) {}

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    let token = this._appService.getAuthToken();

    if (token) {
      req = req.clone({headers: req.headers.set('Authorization', token)});
    }
      //TODO: what to do when the user is saved, but for some reason the token didn't.

    if (!req.headers.has('Content-Type')) {
      req = req.clone({ headers: req.headers.set('Content-Type', 'application/json')});
    }

    req = req.clone({ headers: req.headers.set('Accept', 'application/json') });
    req = req.clone({ url: environment.apiUrl + req.url });

    //TODO: add toaster pop-up to responses such as "201" object created.
    //TODO: add caching

    return next.handle(req).pipe(
      tap((event: HttpEvent<any>) => {
        if (event instanceof HttpResponse) {
          let token = event.headers.get('Token');
          let refresh = event.headers.get('Refresh');

          if (token) {
            this._appService.setAuthToken(token);
          }

          if ( refresh ) {
            this._appService.setRefreshToken(refresh);
          }

          //TODO: globally intercept the body response and change body object keys to camel case.
          // This does it, but the component data response isnt updated.
          // return event.clone({body: SnakeToCamel.do(event.body)});
        }
      },
      (err: any) => {
        let errMsg: string;

        if (err instanceof HttpErrorResponse) {
          if (err.status === 401) {
            this._appService.clear();
            this._router.navigate(['/login']);
          } else {
            const error = err.message || JSON.stringify(err.error);
            errMsg = `${err.status} - ${err.statusText || ''} Details: ${err}`;
          }

        } else {
          errMsg = err.message ? err.message : err.toString();
        }
        return throwError(errMsg);
      })
    );
  }
}

export const AuthInterceptorProvider = {
  provide: HTTP_INTERCEPTORS,
  useClass: AuthInterceptor,
  multi: true,
};
