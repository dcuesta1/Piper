import { Observable, of, throwError } from 'rxjs';
import { flatMap } from 'rxjs/operators';
import { CacheStorageRecord } from '../_models/interfaces/CacheStorageRecord';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class LocalStorage {
  private _prefix = '';
  private _defaultExpires: number = 1800000; //24Hrs

  get size(): Observable<number> {
    return of(localStorage.length);
  }

  /**
   * Gets an item value in local storage
   * @param key The item's key
   * @returns The item's value if the key exists and it's not expired, null otherwise, wrapped in an RxJS Observable
   */
  public getItem<T = any>(key: string): Observable<T | null> {

    const unparsed = localStorage.getItem(`${this._prefix}${key}`);
    let parsedRecord: CacheStorageRecord = {};

    if (unparsed != null) {

      try {
        parsedRecord = JSON.parse(unparsed);
      } catch (error) {
        return throwError(new Error(`Invalid data in localStorage.`));
      }

      if ( parsedRecord.expiry < Date.now() ) {
        parsedRecord = null;
      }

    }

    return of(parsedRecord.data);

  }

  /**
   * Sets an item in local storage
   * @param key The item's key
   * @param data The item's value, must NOT be null or undefined
   * @param expires
   * @returns An RxJS Observable to wait the end of the operation
   */
  setItem(key: string, data: any, expires: number = this._defaultExpires): Observable<boolean> {

    /* Storing undefined in localStorage would then throw when getting and parsing the value */
    if (data == undefined) {
      return throwError(new Error(`Cannot save (cache) value 'undefined' for ${key}`));
    }

    const enhancedData = [];
    // for (const d of data) {
    //   enhancedData.push(d);
    // }

    let record: CacheStorageRecord | null = {
      data: data,
      expiry: Date.now() + expires
    };

    localStorage.setItem(`${this._prefix}${key}`, JSON.stringify(record));

    return of(true);
  }

  /**
   * Deletes an item in local storage
   * @param key The item's key
   * @returns An RxJS Observable to wait the end of the operation
   */
  removeItem(key: string): Observable<boolean> {

    localStorage.removeItem(`${this._prefix}${key}`);

    return of(true);

  }

  /**
   * Deletes all items from local storage
   * @returns An RxJS Observable to wait the end of the operation
   */
  clear(): Observable<boolean> {

    localStorage.clear();

    return of(true);

  }

  /**
   * Retrieves all the keys currently used in local storage
   *
   * @returns {Observable<string[]>}
   * @memberof LocalStorage
   */
  keys(): Observable<string[]> {

    const keys: string[] = [];

    for (let index = 0; index < localStorage.length; index++) {

      keys.push(this.getKey(index) as string);

    }

    return of(keys);

  }

  /**
   * Checks if a key exists in local storage.
   *
   * @param {string} key
   * @returns {Observable<boolean>}
   * @memberof LocalStorage
   */
  has(key: string): Observable<boolean> {

    for (let index = 0; index < localStorage.length; index++) {

      if (key === this.getKey(index)) {

        return of(true);

      }

    }

    return of(false);

  }

  /**
   *
   *
   * @protected
   * @param {number} index
   * @returns {(string | null)}
   * @memberof LocalStorage
   */
  private getKey(index: number): string | null {

    const prefixedKey = localStorage.key(index);

    if (prefixedKey !== null) {

      return (this._prefix === '') ? prefixedKey : prefixedKey.substr(this._prefix.length);

    }

    return null;

  }

  /**
   * Cache or use result from observable
   *
   * If cache key does not exist or is expired, observable supplied in argument is returned and result cached
   *
   * @template T
   * @param {string} key
   * @param {Observable<T>} fallback
   * @param {number} [expires=this._defaultExpires]
   * @returns {Observable<T>}
   * @memberof LocalStorage
   */
  public observable<T>(key: string, fallback: Observable<T>, expires: number = this._defaultExpires): Observable<T> {
    return this.getItem(key).pipe(
      flatMap( (data) => {
        return data ? of(data) : fallback.pipe(
          flatMap( (res: T) => this.setItem(key, res, expires) ));
      })
    );
  }
}
