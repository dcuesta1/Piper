import {Injectable} from '@angular/core';
import {HttpEvent, HttpHandler, HttpInterceptor, HttpRequest, HttpResponse} from '@angular/common/http';
import {AppService} from '../_services/app.service';
import {Router} from '@angular/router';
import {Observable} from 'rxjs';
import { environment as Environment } from '../../environments/environment';
import {tap} from 'rxjs/operators';

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

    if (!req.headers.has('Content-Type')) {
      req = req.clone({ headers: req.headers.set('Content-Type', 'application/json')});
    }

    req = req.clone({ headers: req.headers.set('Accept', 'application/json') });
    req = req.clone({ url: Environment.apiUrl + req.url });

    //TODO: add toaster pop-up to responses such as "201" object created.
    //TODO: add caching

    return next.handle(req).pipe(
      tap((event: HttpEvent<any>) => {
        if (event instanceof HttpResponse) {
          token = event.headers.get('token');

          if (token) {
            this._appService.setAuthToken(token);
          }

          let camelCaseObj = this.keysToCamelCase(event.body);
          return event.clone({body: camelCaseObj});
        }
      })
    )

  }

  private keysToCamelCase(obj) {
    if (obj === Object(obj) && !Array.isArray(obj) && typeof obj !== 'function') {
      const newObj = {};

      Object.keys(obj).forEach(key => {
        newObj[this.toCamelCase(key)]
      });

      return newObj;
    } else  if (Array.isArray(obj)) {
      return obj.map( i => {
        return this.keysToCamelCase(i);
      });
    }
  }

  private toCamelCase(string: String) {
    return string.replace(/([-_][a-z])/ig, ($1) => {
      return $1.toUpperCase()
        .replace('-','')
        .replace('_','')
    });
  }
}
