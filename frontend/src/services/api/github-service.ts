import { Injectable } from '@angular/core';
import { Http, Response } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import { Subject } from 'rxjs/Subject';

export interface IGithubLinks {
  redirect: string;
};

export interface IGithubUser {
  login: string;
  email: string;
  [key: string]: string;
};

@Injectable()
export class GithubService {

  private http: Http;

  constructor(http: Http) {
    this.http = http;
  }

  /**
   *
   */
  getRedirectUrl(): Observable<string> {
    return new Observable<string>((observer) => {

      this.get('api/github/links')
        .subscribe((res: Response) => {
          observer.next(res.json().data.redirect);
        });

    });
  }

  /**
   *
   * @param code
   */
  exchangeCode(code: string): Observable<IGithubUser> {
    return new Observable<IGithubUser>((observer) => {
      this.get('api/github/exchange?code=' + code)
        .subscribe((res: Response) => {
          observer.next(res.json().data);
        })
    });
  }

  getEndpoint(relativeUri: string) {
    // @todo: make this NOT hardcoded
    return 'http://localhost:3000/' + relativeUri;
  }

  /**
   * @todo: extract this into a parent class
   * @param uri
   */
  get(uri): Observable<Response> {
    return this.http.get(this.getEndpoint(uri));
  }
}
