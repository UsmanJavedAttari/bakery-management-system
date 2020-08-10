import { subDays } from 'date-fns';

interface CookiesOption {
  expires?: Date;
  path?: string;
  domain?: string;
  secure?: boolean;
}

export class CookieBrowser {
  private Prefix = '$bakery$';

  public get(key: string): string | null {
    const value = '; ' + document.cookie;
    const parts = value.split(
      '; ' + encodeURIComponent(this.Prefix + key) + '='
    );
    if (parts.length >= 2) {
      return decodeURIComponent(
        parts
          .pop()!
          .split(';')
          .shift()!
      );
    } else {
      return null;
    }
  }
  public set(key: string, value: any, option?: CookiesOption | undefined) {
    key = encodeURIComponent(this.Prefix + key);
    value = encodeURIComponent(value);
    document.cookie =
      key +
      '=' +
      value +
      ';expires=' +
      (option?.expires?.toUTCString() ?? new Date('2035-1-1').toUTCString()) +
      ';path=/';
  }
  public remove(key: string): void {
    document.cookie =
      encodeURIComponent(this.Prefix + key) +
      '=; expires=' +
      subDays(Date.now(), 1).toUTCString() +
      ';path=/';
  }
}
